<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\Consultant; // [NOVO] Importante para buscar os consultores
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PropertyController extends Controller
{
    /**
     * Listagem Administrativa
     */
    public function index()
    {
        // Carrega também o consultor para mostrar na tabela se quiseres
        $properties = Property::with('consultant')->latest()->paginate(10);
        return view('admin.properties.index', compact('properties'));
    }

    public function create()
    {
        // [NOVO] Busca consultores ativos para o Select
        $consultants = Consultant::where('is_active', true)->orderBy('name')->get();
        
        return view('admin.properties.create', compact('consultants'));
    }

    /**
     * Cadastro de novo imóvel
     */
    public function store(Request $request)
    {
        // A validação agora inclui o consultant_id
        $data = $this->validateProperty($request);

        // SEO: Slug único com timestamp
        $data['slug'] = Str::slug($data['title']) . '-' . time();
        
        // Se estiveres a usar autenticação, é boa prática associar o user que criou
        if (auth()->check()) {
            $data['user_id'] = auth()->id();
        }

        // Mapeamento automático de checkboxes (booleans)
        $data = $this->mapCheckboxes($request, $data);

        // Upload da Imagem de Capa
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('properties', 'public');
        }

        $property = Property::create($data);

        // Processamento da Galeria
        $this->handleGalleryUpload($request, $property);

        return redirect()->route('admin.properties.index')->with('success', 'Imóvel cadastrado com sucesso!');
    }

    public function edit(Property $property)
    {
        // [NOVO] Busca consultores para o Select de edição
        $consultants = Consultant::where('is_active', true)->orderBy('name')->get();

        return view('admin.properties.edit', compact('property', 'consultants'));
    }

    /**
     * Atualização de imóvel existente
     */
    public function update(Request $request, Property $property)
    {
        $data = $this->validateProperty($request, $property);

        // Atualiza slug apenas se o título mudar
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

    /**
     * Remoção de imóvel e arquivos associados
     */
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
     * Listagem Pública com Filtros Inteligentes
     */
    public function publicIndex(Request $request)
    {
        $query = Property::with(['images', 'consultant'])->where('is_visible', true);

        // Filtro de Localização (Busca ampla)
        if ($request->filled('location')) {
            $search = $request->location;
            $query->where(function($q) use ($search) {
                $q->where('location', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('reference_code', 'like', "%{$search}%");
            });
        }

        // Filtro de Tipo
        if ($request->filled('type')) {
            $typeMap = [
                'apartamento' => 'apartment',
                'moradia'     => 'house',
                'casa'        => 'house',
                'terreno'     => 'land',
                'loja'        => 'store'
            ];
            $type = $typeMap[strtolower($request->type)] ?? $request->type;
            $query->where('type', $type);
        }

        // Filtro de Status
        if ($request->filled('status')) {
            $statusMap = [
                'disponivel'   => 'available',
                'venda'        => 'available',
                'arrendamento' => 'rent',
                'aluguel'      => 'rent'
            ];
            $status = $statusMap[strtolower($request->status)] ?? $request->status;
            $query->where('status', $status);
        }

        // Filtros de Preço
        if ($request->filled('price_min')) $query->where('price', '>=', $request->price_min);
        if ($request->filled('price_max')) $query->where('price', '<=', $request->price_max);

        // Filtro de Quartos
        if ($request->filled('bedrooms')) {
            if ($request->bedrooms === '4+') {
                $query->where('bedrooms', '>=', 4);
            } else {
                $query->where('bedrooms', (int)$request->bedrooms);
            }
        }

        $properties = $query->latest()->paginate(9)->withQueryString();

        return view('properties.index', compact('properties'));
    }

    public function show(Property $property)
    {
        // [NOVO] Carrega o Consultor junto com as imagens para a página de detalhes
        $property->load(['images', 'consultant']);
        
        return view('properties.show', compact('property'));
    }

    // --- MÉTODOS PRIVADOS DE SUPORTE ---

    private function validateProperty(Request $request, Property $property = null)
    {
        return $request->validate([
            'reference_code' => [
                'nullable', 'string', 'max:20',
                $property 
                    ? Rule::unique('properties', 'reference_code')->ignore($property->id)
                    : 'unique:properties,reference_code'
            ],
            // [NOVO] Validação do Consultor
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
            'cover_image' => 'nullable|image|max:20480', // 20MB
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