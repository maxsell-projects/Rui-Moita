<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Relatório de Simulação de Mais-Valias | Intellectus</title>
    <style>
        @page { margin: 0; }
        body { 
            font-family: 'Helvetica', sans-serif; 
            color: #0A0F14; /* Brand Secondary (Dark) */
            margin: 0; 
            padding: 0; 
            font-size: 11px; 
            background-color: #fff; 
        }
        
        /* HEADER: Azul Profundo (#1B2A41) */
        .header { 
            background-color: #1B2A41; 
            color: #fff; 
            padding: 40px 50px; 
            border-bottom: 4px solid #C5A059; /* Brand Accent (Gold) */
        }
        
        .logo { 
            font-size: 24px; 
            font-weight: bold; 
            letter-spacing: 4px; 
            text-transform: uppercase; 
            margin-bottom: 8px; 
            font-family: 'Times New Roman', serif; 
        }
        
        .subtitle { 
            font-size: 9px; 
            text-transform: uppercase; 
            letter-spacing: 2px; 
            color: #C5A059; /* Gold */
        }
        
        .container { padding: 50px; }
        
        /* SUMMARY BOX: Off-white (#F5F5F2) com Borda Dourada */
        .summary-box { 
            background-color: #F5F5F2; 
            padding: 30px; 
            border-left: 6px solid #C5A059; 
            margin-bottom: 40px; 
        }
        
        .summary-label { 
            font-size: 10px; 
            text-transform: uppercase; 
            letter-spacing: 1px; 
            color: #6B7280; 
            margin-bottom: 8px; 
            font-weight: bold; 
        }
        
        .summary-value { 
            font-size: 36px; 
            font-weight: bold; 
            color: #1B2A41; 
            margin-bottom: 20px; 
            font-family: 'Times New Roman', serif; 
        }
        
        .details-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .details-table th, .details-table td { padding: 12px 0; border-bottom: 1px solid #EEE; text-align: left; }
        
        .details-table th { 
            color: #6B7280; 
            font-weight: normal; 
            font-size: 10px; 
            text-transform: uppercase; 
            letter-spacing: 1px; 
            width: 60%; 
        }
        
        .details-table td { 
            text-align: right; 
            font-weight: bold; 
            color: #0A0F14; 
            font-size: 12px; 
        }
        
        /* Destaque Final: Azul */
        .highlight-row th, .highlight-row td { 
            border-bottom: 2px solid #1B2A41; 
            color: #1B2A41; 
            padding-top: 20px; 
            font-size: 14px; 
        }
        
        .negative { color: #991B1B; /* Vermelho sóbrio para valores negativos */ }
        
        .disclaimer { 
            margin-top: 60px; 
            font-size: 8px; 
            color: #9CA3AF; 
            line-height: 1.6; 
            text-align: justify; 
            border-top: 1px solid #EEE; 
            padding-top: 20px; 
        }
        
        .footer { 
            position: fixed; 
            bottom: 0; 
            left: 0; 
            right: 0; 
            height: 30px; 
            background-color: #1B2A41; 
            color: #C5A059; 
            text-align: center; 
            line-height: 30px; 
            font-size: 8px; 
            text-transform: uppercase; 
            letter-spacing: 2px; 
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="logo">Intellectus</div>
        <div class="subtitle">Rui Moita Private Office • Investment Strategy</div>
    </div>

    <div class="container">
        
        <div class="summary-box">
            <div class="summary-label">Estimativa de Imposto (IRS)</div>
            <div class="summary-value">{{ $results['estimated_tax_fmt'] }} €</div>
            
            <table width="100%">
                <tr>
                    <td style="font-size: 10px; color: #666; text-transform: uppercase;">Mais-Valia Bruta Apurada</td>
                    <td style="text-align: right; font-weight: bold; font-size: 14px; color: #1B2A41;">{{ $results['gross_gain_fmt'] }} €</td>
                </tr>
            </table>
        </div>

        <div style="margin-bottom: 20px; font-size: 12px; font-weight: bold; color: #1B2A41; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #C5A059; display: inline-block; padding-bottom: 5px;">
            Detalhamento do Cálculo
        </div>

        <table class="details-table">
            <tr>
                <th>Valor de Realização (Venda)</th>
                <td>{{ $results['sale_fmt'] }} €</td>
            </tr>
            <tr>
                <th>Valor de Aquisição (Histórico)</th>
                <td>{{ $data['acquisition_value'] }} €</td>
            </tr>
            <tr>
                <th>Coeficiente de Atualização ({{ $data['acquisition_year'] }})</th>
                <td>x {{ $results['coefficient'] }}</td>
            </tr>
            <tr>
                <th style="color: #1B2A41; font-weight: bold;">Valor de Aquisição Atualizado</th>
                <td class="negative">- {{ $results['acquisition_updated_fmt'] }} €</td>
            </tr>
            <tr>
                <th>Despesas e Encargos Dedutíveis</th>
                <td class="negative">- {{ $results['expenses_fmt'] }} €</td>
            </tr>
            
            @if(isset($results['reinvestment_fmt']) && $results['reinvestment_fmt'] != '0,00')
            <tr>
                <th>Reinvestimento (Habitação Própria)</th>
                <td class="negative">- {{ $results['reinvestment_fmt'] }} €</td>
            </tr>
            @endif

            <tr class="highlight-row">
                <th>Matéria Coletável (50% do Saldo)</th>
                <td>{{ $results['taxable_gain_fmt'] }} €</td>
            </tr>
        </table>

        <div class="disclaimer">
            <p><strong>AVISO LEGAL:</strong> Este documento constitui uma simulação meramente indicativa, baseada nos dados fornecidos pelo utilizador e nos coeficientes de desvalorização da moeda em vigor à data da emissão. Não dispensa a consulta da legislação fiscal atualizada nem o aconselhamento profissional de um Contabilista Certificado ou da Autoridade Tributária. A Intellectus Private Office declina qualquer responsabilidade por decisões tomadas com base nesta estimativa.</p>
            <p>Documento gerado automaticamente em {{ $date }}.</p>
        </div>

    </div>

    <div class="footer">
        Intellectus • Rui Moita Private Office • Lisboa
    </div>

</body>
</html>