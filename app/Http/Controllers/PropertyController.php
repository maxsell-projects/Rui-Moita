<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\Consultant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PropertyController extends Controller
{
    /**
     * Listagem Administrativa com Filtros
     */
    public function index(Request $request)
    {
        $query = Property::with('consultant');

        // Filtro: Status de Visibilidade (Ativo/Oculto)
        if ($request->filled('visibility')) {
            $query->where('is_visible', $request->visibility === 'active');
        }

        // Filtro: Objetivo (Venda/Arrendamento)
        // Mapeamos os termos comuns para os valores do banco
        if ($request->filled('intent')) {
            $intent = $request->intent === 'rent' ? 'rent' : 'available';
            $query->where('status', $intent);
        }

        // [BÓNUS] Filtro por Código de Referência ou Título
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('reference_code', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%");
            });
        }

        $properties = $query->latest()->paginate(10)->withQueryString();
        
        return view('admin.properties.index', compact('properties'));
    }

    public function create()
    {
        $consultants = Consultant::where('is_active', true)->orderBy('name')->get();
        return view('admin.properties.create', compact('consultants'));
    }

    public function store(Request $request)
    {
        $data = $this->validateProperty($request);
        $data['slug'] = Str::slug($data['title']) . '-' . time();
        
        if (auth()->check()) {
            $data['user_id'] = auth()->id();
        }

        $data = $this->mapCheckboxes($request, $data);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('properties', 'public');
        }

        $property = Property::create($data);
        $this->handleGalleryUpload($request, $property);

        return redirect()->route('admin.properties.index')->with('success', 'Imóvel cadastrado com sucesso!');
    }

    public function edit(Property $property)
    {
        $consultants = Consultant::where('is_active', true)->orderBy('name')->get();
        return view('admin.properties.edit', compact('property', 'consultants'));
    }

    public function update(Request $request, Property $property)
    {
        $data = $this->validateProperty($request, $property);

        if ($property->title !== $data['title']) {
            $data['slug'] = Str::slug($data['title']) . '-' . time();
        }

        $data = $this->mapCheckboxes($request, $data);

        if ($request->hasFile('cover_image')) {
            if ($property->cover_image) {
                Storage::disk('public')->delete($property->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('properties', 'public');
        }

        $property->update($data);
        $this->handleGalleryUpload($request, $property);

        return redirect()->route('admin.properties.index')->with('success', 'Imóvel atualizado com sucesso!');
    }

    public function destroy(Property $property)
    {
        if ($property->cover_image) {
            Storage::disk('public')->delete($property->cover_image);
        }
        
        foreach ($property->images as $image) {
            Storage::disk('public')->delete($image->path);
        }
        
        $property->delete();
        return back()->with('success', 'Imóvel removido.');
    }

    /**
     * Listagem Pública (Filtros refinados para o site)
     */
    public function publicIndex(Request $request)
    {
        $query = Property::with(['images', 'consultant'])->where('is_visible', true);

        // Localização / Busca Geral
        if ($request->filled('location')) {
            $search = $request->location;
            $query->where(function($q) use ($search) {
                $q->where('location', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('reference_code', 'like', "%{$search}%");
            });
        }

        // Refinamento de Status (Venda vs Arrendamento)
        if ($request->filled('status')) {
            $statusMap = [
                'venda' => 'available',
                'arrendamento' => 'rent',
                'aluguer' => 'rent'
            ];
            $status = $statusMap[strtolower($request->status)] ?? $request->status;
            $query->where('status', $status);
        }

        // Filtro de Tipo de Imóvel
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Preços e Tipologias
        if ($request->filled('price_min')) $query->where('price', '>=', $request->price_min);
        if ($request->filled('price_max')) $query->where('price', '<=', $request->price_max);

        if ($request->filled('bedrooms')) {
            $request->bedrooms === '4+' 
                ? $query->where('bedrooms', '>=', 4) 
                : $query->where('bedrooms', (int)$request->bedrooms);
        }

        $properties = $query->latest()->paginate(9)->withQueryString();

        return view('properties.index', compact('properties'));
    }

    public function show(Property $property)
    {
        $property->load(['images', 'consultant']);
        return view('properties.show', compact('property'));
    }

    // --- HELPER METHODS ---

    private function validateProperty(Request $request, Property $property = null)
    {
        return $request->validate([
            'reference_code' => [
                'nullable', 'string', 'max:20',
                $property ? Rule::unique('properties', 'reference_code')->ignore($property->id) : 'unique:properties,reference_code'
            ],
            'consultant_id' => 'nullable|exists:consultants,id',
            'title' => 'required|string|max:255',
            'price' => 'nullable|numeric',
            'type' => 'required|string',
            'status' => 'required|string',
            'location' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'floor' => 'nullable|string',
            'orientation' => 'nullable|string',
            'area_gross' => 'nullable|numeric',
            'bedrooms' => 'nullable|integer',
            'bathrooms' => 'nullable|integer',
            'garages' => 'nullable|integer',
            'energy_rating' => 'nullable|string',
            'condition' => 'nullable|string',
            'video_url' => 'nullable|url',
            'whatsapp_number' => 'nullable|string',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:20480',
            'gallery.*' => 'image|max:20480',
        ]);
    }

    private function mapCheckboxes(Request $request, array $data)
    {
        $features = [
            'has_pool', 'has_garden', 'has_lift', 'has_terrace', 'has_air_conditioning', 
            'is_furnished', 'is_kitchen_equipped', 'is_visible', 'is_featured'
        ];
        
        foreach ($features as $feature) {
            $data[$feature] = $request->has($feature);
        }
        
        return $data;
    }

    private function handleGalleryUpload(Request $request, Property $property)
    {
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                if ($image->isValid()) {
                    $path = $image->store('properties/gallery', 'public');
                    PropertyImage::create([
                        'property_id' => $property->id,
                        'path' => $path
                    ]);
                }
            }
        }
    }
}