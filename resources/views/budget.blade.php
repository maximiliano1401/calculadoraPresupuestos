<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Calculadora de Presupuesto</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,600,700|fraunces:600,700" rel="stylesheet" />
        <style>
            :root {
                color-scheme: light;
                --bg: #f7f3ec;
                --ink: #1e1b16;
                --muted: #6a6258;
                --accent: #c85b2c;
                --accent-2: #0e6e6a;
                --panel: #fffaf3;
                --panel-strong: #fff1db;
                --border: #e6d7c5;
                --shadow: 0 18px 40px rgba(30, 27, 22, 0.12);
            }

            * {
                box-sizing: border-box;
            }

            body {
                margin: 0;
                font-family: "Space Grotesk", system-ui, -apple-system, "Segoe UI", sans-serif;
                background: radial-gradient(circle at top left, #fff7ea, #f0e8dc 45%, #e9e1d5 100%);
                color: var(--ink);
            }

            .page {
                min-height: 100vh;
                padding: 48px 20px 80px;
                display: flex;
                justify-content: center;
            }

            .shell {
                width: min(1200px, 100%);
                display: grid;
                gap: 24px;
            }

            .hero {
                display: grid;
                gap: 12px;
            }

            .hero h1 {
                font-family: "Fraunces", serif;
                font-size: clamp(32px, 4vw, 52px);
                margin: 0;
            }

            .hero p {
                color: var(--muted);
                margin: 0;
                max-width: 720px;
                font-size: 1rem;
            }

            .layout {
                display: grid;
                gap: 24px;
            }

            @media (min-width: 900px) {
                .layout {
                    grid-template-columns: 1.1fr 0.9fr;
                }
            }

            .panel {
                background: var(--panel);
                border: 1px solid var(--border);
                border-radius: 22px;
                padding: 24px;
                box-shadow: var(--shadow);
            }

            .panel strong {
                color: var(--accent);
            }

            .panel h2 {
                margin: 0 0 12px;
                font-size: 1.2rem;
            }

            .grid {
                display: grid;
                gap: 12px;
            }

            .grid.cols-2 {
                grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            }

            label {
                font-size: 0.85rem;
                color: var(--muted);
                display: block;
                margin-bottom: 6px;
            }

            input {
                width: 100%;
                padding: 10px 12px;
                border-radius: 12px;
                border: 1px solid var(--border);
                background: #fff;
                font-size: 0.95rem;
            }

            .actions {
                display: flex;
                flex-wrap: wrap;
                gap: 12px;
                margin-top: 12px;
            }

            button {
                border: none;
                border-radius: 999px;
                padding: 12px 18px;
                font-weight: 600;
                cursor: pointer;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .primary {
                background: var(--accent);
                color: #fff;
                box-shadow: 0 12px 24px rgba(200, 91, 44, 0.25);
            }

            .secondary {
                background: #f1e7d8;
                color: var(--ink);
            }

            button:hover {
                transform: translateY(-2px);
            }

            .analysis {
                background: var(--panel-strong);
                border-radius: 16px;
                padding: 16px;
                color: var(--ink);
                font-size: 0.95rem;
            }

            .summary {
                display: grid;
                gap: 10px;
                margin-top: 16px;
            }

            .summary-item {
                display: flex;
                justify-content: space-between;
                gap: 16px;
                font-size: 0.95rem;
                color: var(--muted);
            }

            .summary-item strong {
                color: var(--ink);
            }

            .section-title {
                font-size: 1rem;
                margin: 20px 0 10px;
                color: var(--muted);
                text-transform: uppercase;
                letter-spacing: 0.08em;
            }

            .total-card {
                margin-top: 18px;
                padding: 16px;
                border-radius: 16px;
                background: linear-gradient(120deg, #ffe6c7, #ffd4b8);
                color: var(--ink);
                font-size: 1.1rem;
                font-weight: 600;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .results {
                display: grid;
                gap: 12px;
            }

            .pill {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                background: #f4efe6;
                padding: 8px 12px;
                border-radius: 999px;
                font-size: 0.85rem;
                color: var(--muted);
            }

            table {
                width: 100%;
                border-collapse: collapse;
                font-size: 0.92rem;
            }

            th, td {
                text-align: left;
                padding: 10px 8px;
                border-bottom: 1px solid var(--border);
            }

            th {
                color: var(--muted);
                font-weight: 600;
            }

            .json {
                background: #1f1c17;
                color: #e8dccb;
                padding: 16px;
                border-radius: 16px;
                overflow-x: auto;
                font-size: 0.85rem;
                line-height: 1.5;
            }

            .reveal {
                animation: rise 0.6s ease both;
            }

            @keyframes rise {
                from {
                    opacity: 0;
                    transform: translateY(12px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>
    </head>
    <body>
        <div class="page">
            <div class="shell">
                <section class="hero">
                    <span class="pill">Calculadora de presupuesto de software</span>
                    <h1>Visualiza el costo real, rubro por rubro.</h1>
                    <p>Ingresa horas, tarifa, costos fijos y la distribucion porcentual. El sistema normaliza los rubros a 100% y aplica la contingencia al final.</p>
                </section>

                <section class="layout">
                    <div class="panel">
                        <h2>Parametros del proyecto</h2>
                        <div class="grid cols-2">
                            <div>
                                <label for="weeks">Semanas</label>
                                <input id="weeks" type="number" min="1" value="2" />
                            </div>
                            <div>
                                <label for="hours_per_week">Horas por semana</label>
                                <input id="hours_per_week" type="number" min="1" value="40" />
                            </div>
                            <div>
                                <label for="hourly_rate">Tarifa por hora</label>
                                <input id="hourly_rate" type="number" min="0" step="0.01" value="200" />
                            </div>
                            <div>
                                <label for="contingency_percent">Contingencia (%)</label>
                                <input id="contingency_percent" type="number" min="10" max="25" value="12" />
                            </div>
                        </div>

                        <h2 style="margin-top: 20px;">Costos fijos</h2>
                        <div class="grid cols-2">
                            <div>
                                <label for="fixed_infrastructure">Infraestructura</label>
                                <input id="fixed_infrastructure" type="number" min="0" step="0.01" value="600" />
                            </div>
                            <div>
                                <label for="fixed_integrations">Integraciones</label>
                                <input id="fixed_integrations" type="number" min="0" step="0.01" value="1200" />
                            </div>
                            <div>
                                <label for="fixed_platform">Plataforma</label>
                                <input id="fixed_platform" type="number" min="0" step="0.01" value="800" />
                            </div>
                        </div>

                        <h2 style="margin-top: 20px;">Distribucion de rubros (%)</h2>
                        <div class="grid cols-2">
                            <div>
                                <label for="analysis">Analisis</label>
                                <input id="analysis" type="number" min="0" max="100" value="12" />
                            </div>
                            <div>
                                <label for="ux_ui">Diseno UX/UI</label>
                                <input id="ux_ui" type="number" min="0" max="100" value="12" />
                            </div>
                            <div>
                                <label for="complexity">Complejidad</label>
                                <input id="complexity" type="number" min="0" max="100" value="24" />
                            </div>
                            <div>
                                <label for="development">Desarrollo</label>
                                <input id="development" type="number" min="0" max="100" value="45" />
                            </div>
                            <div>
                                <label for="qa_testing">QA y Testing</label>
                                <input id="qa_testing" type="number" min="0" max="100" value="18" />
                            </div>
                            <div>
                                <label for="project_management">Gestion de proyecto</label>
                                <input id="project_management" type="number" min="0" max="100" value="12" />
                            </div>
                            <div>
                                <label for="devops">Despliegue (DevOps)</label>
                                <input id="devops" type="number" min="0" max="100" value="5" />
                            </div>
                        </div>

                        <div class="actions">
                            <button class="primary" id="btn-calc">Calcular presupuesto</button>
                            <button class="secondary" id="btn-example">Generar ejemplo extenso</button>
                        </div>
                    </div>

                    <div class="panel">
                        <h2>Analisis final</h2>
                        <div class="analysis">
                            <p><strong>Como se calcula:</strong> se obtiene el costo base multiplicando horas totales por tarifa. Luego se suman costos fijos y al final se aplica la contingencia sobre el total neto.</p>
                            <p id="normalization-note"><strong>Normalizacion:</strong> si los porcentajes de rubros no suman 100%, se normalizan proporcionalmente.</p>
                        </div>

                        <div class="results" style="margin-top: 20px;">
                            <div class="pill" id="status">Listo para calcular.</div>

                            <div class="section-title">Resumen de parametros</div>
                            <div class="summary">
                                <div class="summary-item">
                                    <span>Tiempo estimado</span>
                                    <strong id="summary-time">-</strong>
                                </div>
                                <div class="summary-item">
                                    <span>Tarifa profesional</span>
                                    <strong id="summary-rate">-</strong>
                                </div>
                                <div class="summary-item">
                                    <span>Costo base mano de obra</span>
                                    <strong id="summary-base">-</strong>
                                </div>
                            </div>

                            <div class="section-title">Desglose por rubros</div>
                            <div>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Concepto</th>
                                            <th>Porcentaje</th>
                                            <th>Monto</th>
                                        </tr>
                                    </thead>
                                    <tbody id="breakdown-table">
                                        <tr>
                                            <td colspan="3">Sin datos aun.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="section-title">Costos adicionales y fijos</div>
                            <div>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Descripcion</th>
                                            <th>Monto</th>
                                        </tr>
                                    </thead>
                                    <tbody id="extra-costs-table">
                                        <tr>
                                            <td colspan="2">Sin datos aun.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="total-card">
                                <span>Total presupuestado</span>
                                <span id="summary-total">-</span>
                            </div>

                            <div class="json" id="json-output" style="margin-top: 18px;">{}</div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <script>
            const fields = [
                'weeks',
                'hours_per_week',
                'hourly_rate',
                'contingency_percent',
                'fixed_infrastructure',
                'fixed_integrations',
                'fixed_platform',
                'analysis',
                'ux_ui',
                'complexity',
                'development',
                'qa_testing',
                'project_management',
                'devops',
            ];

            const exampleExtenso = {
                weeks: 6,
                hours_per_week: 45,
                hourly_rate: 240,
                contingency_percent: 18,
                fixed_costs: {
                    infrastructure: 1800,
                    integrations: 2600,
                    platform: 1400,
                },
                breakdown: {
                    analysis: 13,
                    ux_ui: 14,
                    complexity: 28,
                    development: 48,
                    qa_testing: 19,
                    project_management: 14,
                    devops: 5,
                },
            };

            const inputs = Object.fromEntries(fields.map((id) => [id, document.getElementById(id)]));
            const statusEl = document.getElementById('status');
            const tableBody = document.getElementById('breakdown-table');
            const extraCostsBody = document.getElementById('extra-costs-table');
            const jsonOutput = document.getElementById('json-output');
            const summaryTime = document.getElementById('summary-time');
            const summaryRate = document.getElementById('summary-rate');
            const summaryBase = document.getElementById('summary-base');
            const summaryTotal = document.getElementById('summary-total');
            const normalizationNote = document.getElementById('normalization-note');

            const formatMoney = (value) =>
                new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(value);

            const breakdownLabels = {
                analysis: 'Analisis',
                ux_ui: 'Diseno UX/UI',
                complexity: 'Complejidad',
                development: 'Desarrollo',
                qa_testing: 'QA y Testing',
                project_management: 'Gestion de proyecto',
                devops: 'Despliegue (DevOps)',
            };

            const payloadFromInputs = () => ({
                weeks: Number(inputs.weeks.value),
                hours_per_week: Number(inputs.hours_per_week.value),
                hourly_rate: Number(inputs.hourly_rate.value),
                contingency_percent: Number(inputs.contingency_percent.value),
                fixed_costs: {
                    infrastructure: Number(inputs.fixed_infrastructure.value),
                    integrations: Number(inputs.fixed_integrations.value),
                    platform: Number(inputs.fixed_platform.value),
                },
                breakdown: {
                    analysis: Number(inputs.analysis.value),
                    ux_ui: Number(inputs.ux_ui.value),
                    complexity: Number(inputs.complexity.value),
                    development: Number(inputs.development.value),
                    qa_testing: Number(inputs.qa_testing.value),
                    project_management: Number(inputs.project_management.value),
                    devops: Number(inputs.devops.value),
                },
            });

            const renderResults = (data) => {
                statusEl.textContent = 'Calculo listo. Total bruto: ' + formatMoney(data.totals.gross_cost);
                statusEl.classList.add('reveal');

                summaryTime.textContent = `${data.input.weeks} semanas (${data.totals.total_hours} horas totales)`;
                summaryRate.textContent = formatMoney(data.input.hourly_rate) + ' / hora';
                summaryBase.textContent = formatMoney(data.totals.base_cost);
                summaryTotal.textContent = formatMoney(data.totals.gross_cost);

                normalizationNote.textContent = `Normalizacion: suma original ${data.input.breakdown_sum_original}% -> normalizada a ${data.input.breakdown_sum_normalized}%.`;

                tableBody.innerHTML = data.breakdown
                    .map(
                        (item) =>
                            `<tr><td>${breakdownLabels[item.key] || item.key}</td><td>${item.percent}%</td><td>${formatMoney(item.amount)}</td></tr>`
                    )
                    .join('');

                extraCostsBody.innerHTML = [
                    {
                        label: `Contingencia (${data.input.contingency_percent}%)`,
                        amount: data.totals.contingency_amount,
                    },
                    { label: 'Infraestructura', amount: data.input.fixed_costs.infrastructure },
                    { label: 'Integraciones', amount: data.input.fixed_costs.integrations },
                    { label: 'Plataforma', amount: data.input.fixed_costs.platform },
                ]
                    .map(
                        (item) =>
                            `<tr><td>${item.label}</td><td>${formatMoney(item.amount)}</td></tr>`
                    )
                    .join('');

                jsonOutput.textContent = JSON.stringify(data, null, 2);
            };

            const renderError = (message) => {
                statusEl.textContent = message;
                tableBody.innerHTML = '<tr><td colspan="3">Sin datos disponibles.</td></tr>';
                extraCostsBody.innerHTML = '<tr><td colspan="2">Sin datos disponibles.</td></tr>';
                summaryTime.textContent = '-';
                summaryRate.textContent = '-';
                summaryBase.textContent = '-';
                summaryTotal.textContent = '-';
                jsonOutput.textContent = '{}';
            };

            const calculate = async () => {
                statusEl.textContent = 'Calculando...';
                try {
                    const response = await fetch('/api/budget/calculate', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            Accept: 'application/json',
                        },
                        body: JSON.stringify(payloadFromInputs()),
                    });

                    if (!response.ok) {
                        let errorMessage = `Error ${response.status}: ${response.statusText}`;
                        const contentType = response.headers.get('content-type') || '';

                        if (contentType.includes('application/json')) {
                            const errorData = await response.json();
                            if (errorData.message) {
                                errorMessage = errorData.message;
                            } else if (errorData.errors) {
                                errorMessage = Object.values(errorData.errors).flat().join(' ');
                            }
                        }

                        throw new Error(errorMessage || 'Error al calcular.');
                    }

                    const data = await response.json();
                    renderResults(data);
                } catch (error) {
                    renderError(error.message);
                }
            };

            document.getElementById('btn-calc').addEventListener('click', calculate);
            document.getElementById('btn-example').addEventListener('click', () => {
                inputs.weeks.value = exampleExtenso.weeks;
                inputs.hours_per_week.value = exampleExtenso.hours_per_week;
                inputs.hourly_rate.value = exampleExtenso.hourly_rate;
                inputs.contingency_percent.value = exampleExtenso.contingency_percent;
                inputs.fixed_infrastructure.value = exampleExtenso.fixed_costs.infrastructure;
                inputs.fixed_integrations.value = exampleExtenso.fixed_costs.integrations;
                inputs.fixed_platform.value = exampleExtenso.fixed_costs.platform;
                inputs.analysis.value = exampleExtenso.breakdown.analysis;
                inputs.ux_ui.value = exampleExtenso.breakdown.ux_ui;
                inputs.complexity.value = exampleExtenso.breakdown.complexity;
                inputs.development.value = exampleExtenso.breakdown.development;
                inputs.qa_testing.value = exampleExtenso.breakdown.qa_testing;
                inputs.project_management.value = exampleExtenso.breakdown.project_management;
                inputs.devops.value = exampleExtenso.breakdown.devops;
                calculate();
            });
        </script>
    </body>
</html>
