<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GainsSimulatorController extends Controller
{
    private function getMonetaryCoefficient(int $year): float
    {
        $coefficients = [
            2025 => 1.000, // Ano da alienação
            2024 => 1.000,
            2023 => 1.040,
            2022 => 1.090,
            2021 => 1.130,
            2020 => 1.160,
            2019 => 1.160,
            2018 => 1.160,
            2017 => 1.160,
            2016 => 1.160,
            2015 => 1.160,
            2014 => 1.160,
            2013 => 1.160,
            2012 => 1.160,
            // ... Adicionar todos os anos restantes conforme a Portaria
            // Exemplo fictício para anos mais antigos:
            1990 => 2.050,
            1980 => 5.200,
            // ...
        ];

        return $coefficients[$year] ?? 1.000;
    }

    public function calculateGains(Request $request)
    {
        $data = $request->validate([
            'acquisition_year' => 'required|integer',
            'acquisition_value' => 'required|numeric|min:0',
            'sale_value' => 'required|numeric|min:0',
            'has_expenses' => 'required|boolean',
            'is_hpp' => 'required|string', // Sim / Não, era há menos de 12 meses / Não
            'reinvestment_amount' => 'nullable|numeric|min:0',
            'taxable_income' => 'nullable|numeric|min:0',
            // ... Outros campos (amortization, joint_return, public_support)
        ]);

        $acquisitionValue = (float) $data['acquisition_value'];
        $saleValue = (float) $data['sale_value'];
        $acquisitionYear = (int) $data['acquisition_year'];
        $expenses = $data['has_expenses'] ? 5000 : 0; // Exemplo de despesas, o ideal seria ter um campo

        $coefficient = $this->getMonetaryCoefficient($acquisitionYear);

        // 1. Cálculo da Mais-Valia Bruta
        $correctedAcquisitionValue = $acquisitionValue * $coefficient;
        $capitalGainsBrute = $saleValue - ($correctedAcquisitionValue + $expenses);
        
        $taxableAmount = 0;
        $isExempt = false;

        if ($capitalGainsBrute > 0) {
            // 2. Aplicação das Regras de Isenção (HPP)
            if ($data['is_hpp'] === 'Sim') {
                $reinvestmentAmount = (float) $data['reinvestment_amount'];
                
                if ($reinvestmentAmount >= $saleValue) {
                    $isExempt = true; // Isenção total se reinvestir o valor total de venda
                } else if ($reinvestmentAmount > 0) {
                    // Isenção Proporcional
                    // (Valor de Realização - Valor de Reinvestimento) / Valor de Realização
                    $exemptionRatio = ($saleValue - $reinvestmentAmount) / $saleValue;
                    $nonExemptGains = $capitalGainsBrute * $exemptionRatio;
                    $taxableAmount = $nonExemptGains * 0.50; // Tributação sobre 50%
                    $isExempt = false;
                } else {
                    $taxableAmount = $capitalGainsBrute * 0.50; // Tributação sobre 50%
                }
            } else {
                // Não é HPP (Segunda habitação) ou HPP < 12 meses
                $taxableAmount = $capitalGainsBrute * 0.50; // Tributação sobre 50%
            }

            // 3. Estimativa de Imposto (Simples)
            // A taxa efetiva de IRS depende do englobamento com o rendimento coletável, o que é complexo.
            // Para a simulação, vamos retornar o valor tributável.
            // O usuário pode usar a alíquota marginal (taxa máxima) do IRS para ter uma estimativa.
            // Exemplo simplificado de Taxa Máxima (depende do rendimento anual):
            $estimatedTaxRate = 0.28; // 28% é uma alíquota média/estimativa.
            
            if ($data['taxable_income']) {
                 // **NOTA:** Aqui deve entrar a lógica complexa de englobamento/tabelas de IRS.
                 // Para este MVP, vou manter a taxa estimada de 28% sobre a parcela tributável.
                 // A forma correta seria simular o IRS com e sem a mais-valia.
                 // estimatedTaxRate = $this->getIrsRate((float) $data['taxable_income'] + $taxableAmount);
            }

            $estimatedTax = $taxableAmount * $estimatedTaxRate;


        } else {
            $capitalGainsBrute = 0; // Menos-valia
            $taxableAmount = 0;
            $estimatedTax = 0;
        }

        // Simulação enviada para o serviço de Lead
        $simulationResults = [
            'capital_gains_brute' => number_format($capitalGainsBrute, 2, ',', '.') . ' €',
            'corrected_acquisition_value' => number_format($correctedAcquisitionValue, 2, ',', '.') . ' €',
            'taxable_amount' => number_format($taxableAmount, 2, ',', '.') . ' €',
            'estimated_tax' => number_format($estimatedTax, 2, ',', '.') . ' €',
            'is_exempt' => $isExempt,
        ];
        
        // Chamada ao Job/Service para Gerar PDF e enviar e-mail
        // $this->sendSimulationToLead($request->all(), $simulationResults); 

        return response()->json($simulationResults);
    }
}