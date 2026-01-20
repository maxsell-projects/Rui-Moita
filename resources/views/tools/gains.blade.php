@extends('layouts.app')

@section('content')

{{-- HERO SECTION --}}
<div class="bg-brand-primary text-white pt-32 pb-20 text-center relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
    
    <div class="container mx-auto px-6 relative z-10" data-aos="fade-up">
        <p class="text-brand-premium font-mono text-xs uppercase tracking-[0.4em] mb-6">
            Fiscalidade & Estratégia
        </p>
        <h1 class="text-4xl md:text-6xl font-didot leading-tight">
            Simulador de Mais-Valias
        </h1>
        <p class="text-gray-300 font-light max-w-2xl mx-auto mt-6 text-lg">
            Antecipe o impacto fiscal da venda do seu imóvel. Calcule a estimativa de IRS a pagar com rigor e transparência.
        </p>
    </div>
</div>

<section class="py-20 bg-brand-background" x-data="gainsForm()">
    <div class="container mx-auto px-6 max-w-7xl">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16">
            
            {{-- COLUNA DA ESQUERDA: FORMULÁRIO --}}
            <div class="lg:col-span-8 space-y-8">
                
                {{-- 1. Aquisição --}}
                <div class="bg-white p-8 rounded-lg shadow-sm border-t-4 border-brand-premium" data-aos="fade-up">
                    <div class="flex items-center gap-4 mb-8">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-brand-primary text-white font-serif font-bold text-sm">1</span>
                        <h3 class="text-xl font-didot text-brand-primary">Dados da Aquisição (Compra)</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">Valor de Compra (€)</label>
                            <input type="number" step="0.01" x-model="form.acquisition_value" 
                                   class="w-full bg-gray-50 border-0 border-b-2 border-gray-200 px-4 py-3 focus:ring-0 focus:border-brand-premium transition-colors text-brand-primary placeholder-gray-300" 
                                   placeholder="Ex: 150000.00">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">Ano</label>
                                <select x-model="form.acquisition_year" class="w-full bg-gray-50 border-0 border-b-2 border-gray-200 px-4 py-3 focus:ring-0 focus:border-brand-premium cursor-pointer text-brand-primary">
                                    @foreach(range(2025, 1901) as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">Mês</label>
                                <select x-model="form.acquisition_month" class="w-full bg-gray-50 border-0 border-b-2 border-gray-200 px-4 py-3 focus:ring-0 focus:border-brand-premium cursor-pointer text-brand-primary">
                                    @foreach(['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'] as $month)
                                        <option value="{{ $month }}">{{ $month }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <label class="block text-sm font-medium text-gray-700 mb-3">A habitação foi construída pelo próprio?</label>
                        <div class="flex gap-6">
                            <label class="inline-flex items-center cursor-pointer group">
                                <input type="radio" value="Sim" x-model="form.self_built" class="peer sr-only">
                                <span class="w-4 h-4 border border-gray-300 rounded-full peer-checked:bg-brand-premium peer-checked:border-brand-premium transition-all"></span>
                                <span class="ml-2 text-sm text-gray-600 group-hover:text-brand-primary transition-colors">Sim</span>
                            </label>
                            <label class="inline-flex items-center cursor-pointer group">
                                <input type="radio" value="Não" x-model="form.self_built" class="peer sr-only">
                                <span class="w-4 h-4 border border-gray-300 rounded-full peer-checked:bg-brand-premium peer-checked:border-brand-premium transition-all"></span>
                                <span class="ml-2 text-sm text-gray-600 group-hover:text-brand-primary transition-colors">Não</span>
                            </label>
                        </div>
                        <p class="text-[10px] text-gray-400 mt-2 italic">*Afeta o coeficiente de desvalorização da moeda.</p>
                    </div>
                </div>

                {{-- 2. Venda --}}
                <div class="bg-white p-8 rounded-lg shadow-sm border-t-4 border-brand-premium" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-center gap-4 mb-8">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-brand-primary text-white font-serif font-bold text-sm">2</span>
                        <h3 class="text-xl font-didot text-brand-primary">Dados da Realização (Venda)</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">Valor de Venda (€)</label>
                            <input type="number" step="0.01" x-model="form.sale_value" 
                                   class="w-full bg-gray-50 border-0 border-b-2 border-gray-200 px-4 py-3 focus:ring-0 focus:border-brand-premium transition-colors text-brand-primary placeholder-gray-300" 
                                   placeholder="Ex: 350000.00">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">Ano</label>
                                <select x-model="form.sale_year" class="w-full bg-gray-50 border-0 border-b-2 border-gray-200 px-4 py-3 focus:ring-0 focus:border-brand-premium cursor-pointer text-brand-primary">
                                    @foreach(range(2025, 1901) as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">Mês</label>
                                <select x-model="form.sale_month" class="w-full bg-gray-50 border-0 border-b-2 border-gray-200 px-4 py-3 focus:ring-0 focus:border-brand-premium cursor-pointer text-brand-primary">
                                    @foreach(['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'] as $month)
                                        <option value="{{ $month }}">{{ $month }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 3. Despesas --}}
                <div class="bg-white p-8 rounded-lg shadow-sm border-t-4 border-brand-premium" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-center gap-4 mb-8">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-brand-primary text-white font-serif font-bold text-sm">3</span>
                        <h3 class="text-xl font-didot text-brand-primary">Despesas Dedutíveis</h3>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Existem despesas a deduzir (Obras, IMT, Comissões)?</label>
                        <div class="flex gap-6">
                            <label class="inline-flex items-center cursor-pointer group">
                                <input type="radio" value="Sim" x-model="form.has_expenses" class="peer sr-only">
                                <div class="px-4 py-2 border border-gray-200 rounded text-sm peer-checked:bg-brand-primary peer-checked:text-white peer-checked:border-brand-primary transition-all group-hover:border-brand-primary">Sim</div>
                            </label>
                            <label class="inline-flex items-center cursor-pointer group">
                                <input type="radio" value="Não" x-model="form.has_expenses" class="peer sr-only">
                                <div class="px-4 py-2 border border-gray-200 rounded text-sm peer-checked:bg-brand-primary peer-checked:text-white peer-checked:border-brand-primary transition-all group-hover:border-brand-primary">Não</div>
                            </label>
                        </div>
                    </div>

                    <div x-show="form.has_expenses === 'Sim'" x-transition class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-[#F5F7FA] p-6 rounded border border-gray-200">
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-2">Obras / Melhorias (€)</label>
                            <input type="number" step="0.01" x-model="form.expenses_works" class="w-full border-gray-200 rounded px-3 py-2 text-sm focus:border-brand-cta focus:ring-0">
                            <p class="text-[10px] text-gray-400 mt-1">*Últimos 12 anos apenas.</p>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-2">IMT e Selo da Compra (€)</label>
                            <input type="number" step="0.01" x-model="form.expenses_imt" class="w-full border-gray-200 rounded px-3 py-2 text-sm focus:border-brand-cta focus:ring-0">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-2">Comissão Imobiliária (€)</label>
                            <input type="number" step="0.01" x-model="form.expenses_commission" class="w-full border-gray-200 rounded px-3 py-2 text-sm focus:border-brand-cta focus:ring-0">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-2">Registo / Notariado (€)</label>
                            <input type="number" step="0.01" x-model="form.expenses_other" class="w-full border-gray-200 rounded px-3 py-2 text-sm focus:border-brand-cta focus:ring-0">
                        </div>
                    </div>
                </div>

                {{-- 4. Enquadramento Fiscal --}}
                <div class="bg-white p-8 rounded-lg shadow-sm border-t-4 border-brand-premium" data-aos="fade-up" data-aos-delay="300">
                    <div class="flex items-center gap-4 mb-8">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-brand-primary text-white font-serif font-bold text-sm">4</span>
                        <h3 class="text-xl font-didot text-brand-primary">Enquadramento Fiscal</h3>
                    </div>

                    {{-- Venda ao Estado --}}
                    <div class="mb-8 border-b border-gray-100 pb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-3">Venda a Entidade Pública (Estado/Autarquias)?</label>
                        <div class="flex gap-6">
                            <label class="inline-flex items-center cursor-pointer group">
                                <input type="radio" value="Sim" x-model="form.sold_to_state" @change="resetHPPFields" class="peer sr-only">
                                <span class="w-4 h-4 border border-gray-300 rounded-full peer-checked:bg-brand-premium peer-checked:border-brand-premium transition-all"></span>
                                <span class="ml-2 text-sm text-gray-600">Sim</span>
                            </label>
                            <label class="inline-flex items-center cursor-pointer group">
                                <input type="radio" value="Não" x-model="form.sold_to_state" @change="resetHPPFields" class="peer sr-only">
                                <span class="w-4 h-4 border border-gray-300 rounded-full peer-checked:bg-brand-premium peer-checked:border-brand-premium transition-all"></span>
                                <span class="ml-2 text-sm text-gray-600">Não</span>
                            </label>
                        </div>
                        <div x-show="form.sold_to_state === 'Sim'" x-transition class="mt-4 p-3 bg-blue-50 border border-blue-100 text-blue-800 text-xs font-bold rounded">
                            ℹ️ Isenção total de IRS aplicável.
                        </div>
                    </div>

                    <div x-show="form.sold_to_state === 'Não'" x-transition class="space-y-8">
                        
                        {{-- HPP --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">Status do Imóvel na Venda</label>
                            <div class="space-y-3">
                                <label class="flex items-center cursor-pointer p-3 border border-gray-200 rounded hover:bg-gray-50 transition">
                                    <input type="radio" value="Sim" x-model="form.hpp_status" @change="resetReinvestmentFields" class="accent-brand-premium w-4 h-4">
                                    <span class="ml-3 text-sm text-gray-700">Habitação Própria Permanente (HPP) há +12 meses</span>
                                </label>
                                <label class="flex items-center cursor-pointer p-3 border border-gray-200 rounded hover:bg-gray-50 transition">
                                    <input type="radio" value="Menos12Meses" x-model="form.hpp_status" @change="resetReinvestmentFields" class="accent-brand-premium w-4 h-4">
                                    <span class="ml-3 text-sm text-gray-700">HPP há menos de 12 meses</span>
                                </label>
                                <label class="flex items-center cursor-pointer p-3 border border-gray-200 rounded hover:bg-gray-50 transition">
                                    <input type="radio" value="Não" x-model="form.hpp_status" @change="resetReinvestmentFields" class="accent-brand-premium w-4 h-4">
                                    <span class="ml-3 text-sm text-gray-700">Secundária / Investimento / Terreno</span>
                                </label>
                            </div>
                        </div>

                        {{-- Isenções --}}
                        <div class="bg-[#F5F7FA] p-6 rounded border border-gray-200">
                            <h4 class="text-sm font-bold text-brand-primary uppercase tracking-widest mb-4">Reinvestimento & Benefícios</h4>
                            
                            {{-- Reinvestimento --}}
                            <div class="mb-6" x-show="form.hpp_status === 'Sim'">
                                <label class="block text-xs font-bold text-gray-500 mb-2">Intenção de Reinvestimento (HPP)</label>
                                <div class="flex gap-4 mb-3">
                                    <label class="inline-flex items-center cursor-pointer"><input type="radio" value="Sim" x-model="form.reinvest_intention" class="accent-brand-premium w-4 h-4"><span class="ml-2 text-sm">Sim</span></label>
                                    <label class="inline-flex items-center cursor-pointer"><input type="radio" value="Não" x-model="form.reinvest_intention" class="accent-brand-premium w-4 h-4"><span class="ml-2 text-sm">Não</span></label>
                                </div>
                                <div x-show="form.reinvest_intention === 'Sim'" x-transition>
                                    <input type="number" step="0.01" x-model="form.reinvestment_amount" class="w-full border-gray-300 rounded text-sm focus:border-brand-cta focus:ring-0" placeholder="Valor a reinvestir (€)">
                                </div>
                            </div>

                            {{-- Amortização --}}
                            <div class="mb-6">
                                <label class="block text-xs font-bold text-gray-500 mb-2">Amortização de Crédito (Norma Transitória)</label>
                                <div class="flex gap-4 mb-3">
                                    <label class="inline-flex items-center cursor-pointer"><input type="radio" value="Sim" x-model="form.amortize_credit" class="accent-brand-premium w-4 h-4"><span class="ml-2 text-sm">Sim</span></label>
                                    <label class="inline-flex items-center cursor-pointer"><input type="radio" value="Não" x-model="form.amortize_credit" class="accent-brand-premium w-4 h-4"><span class="ml-2 text-sm">Não</span></label>
                                </div>
                                <div x-show="form.amortize_credit === 'Sim'" x-transition>
                                    <input type="number" step="0.01" x-model="form.amortization_amount" class="w-full border-gray-300 rounded text-sm focus:border-brand-cta focus:ring-0" placeholder="Valor a amortizar (€)">
                                </div>
                            </div>

                            {{-- Rendimentos --}}
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-2">Rendimento Anual Coletável (IRS - Anexo A)</label>
                                <input type="number" step="0.01" x-model="form.annual_income" class="w-full border-gray-300 rounded text-sm focus:border-brand-cta focus:ring-0" placeholder="Ex: 30000.00">
                            </div>
                        </div>

                    </div>
                </div>

                <div class="pt-6">
                    <button type="button" @click="openModal" class="w-full bg-brand-cta text-white font-bold py-5 rounded shadow-lg hover:bg-opacity-90 transition-all uppercase tracking-[0.2em] text-sm transform hover:-translate-y-1">
                        Calcular Imposto
                    </button>
                </div>

            </div>

            {{-- COLUNA DA DIREITA: RESULTADOS (STICKY) --}}
            <div class="lg:col-span-4" id="results-area">
                <div class="sticky top-32 space-y-6">
                    
                    {{-- Placeholder State --}}
                    <div x-show="!hasCalculated" class="bg-white border-2 border-dashed border-gray-200 rounded-lg p-10 text-center text-gray-400">
                        <svg class="w-12 h-12 mx-auto mb-4 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        <p class="text-xs uppercase tracking-widest">A aguardar dados...</p>
                    </div>

                    {{-- Result State --}}
                    <div x-show="hasCalculated" x-transition style="display: none;" class="space-y-6">
                        
                        {{-- Main Result Card --}}
                        <div class="bg-brand-primary text-white rounded-lg p-8 shadow-2xl relative overflow-hidden">
                            <div class="absolute -top-10 -right-10 w-40 h-40 bg-brand-premium/20 rounded-full blur-3xl"></div>
                            
                            <h3 class="text-xs font-bold text-brand-premium uppercase tracking-[0.2em] mb-2">Imposto Estimado (IRS)</h3>
                            <div class="text-5xl font-didot mb-8" x-text="results.estimated_tax_fmt + ' €'"></div>
                            
                            <div class="space-y-3 text-sm font-light border-t border-white/10 pt-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-400">Mais-Valia Bruta</span>
                                    <span x-text="results.gross_gain_fmt + ' €'"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-400">Base Tributável (50%)</span>
                                    <span x-text="results.taxable_gain_fmt + ' €'" class="font-bold text-white"></span>
                                </div>
                            </div>
                        </div>

                        {{-- Details Card --}}
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden text-sm">
                            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 font-bold text-brand-primary uppercase text-xs tracking-widest">
                                Detalhe da Operação
                            </div>
                            <div class="p-6 space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Realização (Venda)</span>
                                    <span class="font-medium" x-text="results.sale_fmt + ' €'"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Coef. Atualização</span>
                                    <span class="font-medium" x-text="results.coefficient"></span>
                                </div>
                                <div class="flex justify-between text-brand-cta">
                                    <span>Aquisição Atualizada</span>
                                    <span x-text="'- ' + results.acquisition_updated_fmt + ' €'"></span>
                                </div>
                                <div class="flex justify-between text-brand-cta">
                                    <span>Despesas</span>
                                    <span x-text="'- ' + results.expenses_fmt + ' €'"></span>
                                </div>
                                <div class="flex justify-between text-brand-secondary font-bold" x-show="results.reinvestment_fmt !== '0,00' || form.amortize_credit === 'Sim'">
                                    <span>Isenção (Reinvest/Amort)</span>
                                    <span x-text="'- ' + results.reinvestment_fmt + ' €'"></span>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 bg-brand-premium/10 border border-brand-premium/30 rounded text-xs text-brand-primary leading-relaxed">
                            <strong class="block mb-1 font-bold">Nota Técnica:</strong>
                            A tributação incide sobre 50% da mais-valia líquida para residentes fiscais em Portugal, sendo englobada aos restantes rendimentos.
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- MODAL DE LEAD (PRIVATE OFFICE STYLE) --}}
    <div x-show="showLeadModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            
            <div x-show="showLeadModal" x-transition.opacity class="fixed inset-0 bg-brand-primary/90 backdrop-blur-sm transition-opacity" @click="showLeadModal = false"></div>

            <div x-show="showLeadModal" x-transition.scale class="relative inline-block bg-white rounded-lg text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-lg w-full border-t-4 border-brand-premium">
                <div class="bg-white px-8 py-10">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-didot text-brand-primary mb-2">Relatório Detalhado</h3>
                        <p class="text-sm text-gray-500 font-light">Para aceder à análise completa e receber o PDF oficial, por favor identifique-se.</p>
                    </div>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2">Nome Completo</label>
                            <input type="text" x-model="form.lead_name" class="w-full border-0 border-b border-gray-300 px-0 py-2 focus:ring-0 focus:border-brand-premium transition-colors placeholder-gray-300">
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2">Email Corporativo / Pessoal</label>
                            <input type="email" x-model="form.lead_email" class="w-full border-0 border-b border-gray-300 px-0 py-2 focus:ring-0 focus:border-brand-premium transition-colors placeholder-gray-300">
                        </div>
                    </div>

                    <div class="mt-10">
                        <button type="button" @click="submit" class="w-full bg-brand-primary text-white font-bold py-4 rounded shadow-lg hover:bg-brand-cta transition-colors uppercase tracking-widest text-xs">
                            Ver Resultado & Receber PDF
                        </button>
                        <button type="button" @click="showLeadModal = false" class="mt-4 w-full text-gray-400 text-xs hover:text-brand-primary transition">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

<script>
    function gainsForm() {
        return {
            hasCalculated: false,
            showLeadModal: false,
            form: {
                acquisition_value: '',
                acquisition_year: 2015,
                acquisition_month: 'Janeiro',
                sale_value: '',
                sale_year: 2025,
                sale_month: 'Janeiro',
                has_expenses: 'Não',
                expenses_works: '',
                expenses_imt: '',
                expenses_commission: '',
                expenses_other: '',
                sold_to_state: 'Não',
                hpp_status: 'Sim',
                amortize_credit: 'Não',
                amortization_amount: '',
                joint_tax_return: 'Não',
                annual_income: '',
                public_support: 'Não',
                public_support_year: 2020,
                public_support_month: 'Janeiro',
                retired_status: 'Não', 
                self_built: 'Não', 
                reinvest_intention: 'Não',
                reinvestment_amount: '',
                lead_name: '',
                lead_email: ''
            },
            results: {
                sale_fmt: '0,00',
                coefficient: '1,00',
                acquisition_updated_fmt: '0,00',
                expenses_fmt: '0,00',
                reinvestment_fmt: '0,00',
                gross_gain_fmt: '0,00',
                taxable_gain_fmt: '0,00',
                estimated_tax_fmt: '0,00',
                status: ''
            },
            
            resetHPPFields() {
                if(this.form.sold_to_state === 'Sim') {
                    this.form.hpp_status = 'Não'; 
                }
                this.resetReinvestmentFields();
            },

            resetReinvestmentFields() {
                 if(this.form.hpp_status !== 'Sim') {
                    this.form.reinvest_intention = 'Não';
                    this.form.reinvestment_amount = '';
                    this.form.retired_status = 'Não'; 
                }
            },
            
            openModal() {
                if(!this.form.acquisition_value || !this.form.sale_value) {
                    alert("Por favor, preencha os valores de Aquisição e Venda.");
                    return;
                }
                this.showLeadModal = true;
            },

            async submit() {
                if(!this.form.lead_name || !this.form.lead_email) {
                    alert("Por favor, preencha o seu nome e email.");
                    return;
                }

                try {
                    if(this.form.sold_to_state === 'Sim') {
                        this.form.annual_income = 0; 
                    }

                    const response = await fetch('{{ route('tools.gains.calculate') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(this.form)
                    });
                    
                    if (!response.ok) {
                        alert('Ocorreu um erro no cálculo. Verifique os dados inseridos.');
                        return;
                    }

                    this.results = await response.json();
                    this.hasCalculated = true;
                    this.showLeadModal = false; 
                    
                    this.$nextTick(() => {
                        document.getElementById('results-area').scrollIntoView({ behavior: 'smooth', block: 'start' });
                    });

                } catch (e) {
                    console.error("Erro:", e);
                }
            }
        }
    }
</script>
@endsection