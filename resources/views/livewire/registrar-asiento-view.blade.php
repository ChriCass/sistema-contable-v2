<div>
    <x-card>
        <h1 class="font-bold">Esta es la vista de registro de asiento</h1>
    </x-card>

    <x-card class="p-4 w-full my-3">
        <div class="grid grid-cols-2 gap-4">
            <div class="space-y-2">
                <div class="text-sm font-bold">LIBRO:</div>
                <div class="text-sm font-bold">MES:</div>
                <div class="text-sm font-bold">FECHA:</div>
                <div class="text-sm font-bold">GLOSA GEN:</div>
                <div class="text-sm font-bold">MONEDA:</div>
            </div>
            <div class="flex items-start">
                <button class="bg-teal-600 text-white py-2 px-4 rounded shadow">
                    Procesar
                </button>
            </div>
        </div>
    </x-card>

    <!-- Sección de Tabla con Scroll -->
    <x-card class="p-4 w-full overflow-x-auto" x-data="asientoManager()">
        <table class="min-w-full bg-white rounded shadow">
            <thead class="bg-teal-600 text-white">
                <tr>
                    <th class="p-2 text-left">CNTA</th>
                    <th class="p-2 text-left">ASIENTO</th>
                    <th class="p-2 text-left">DESCRIPCIÓN</th>
                    <th class="p-2 text-left">DEBE S/</th>
                    <th class="p-2 text-left">HABER</th>
                    <th class="p-2 text-left">DEBE $</th>
                    <th class="p-2 text-left">HABER $</th>
                    <th class="p-2 text-left">T.C</th>
                    <th class="p-2 text-left">GLOSA ESPECÍFICA</th>
                    <th class="p-2 text-left">RAZ SOCIAL</th>
                    <th class="p-2 text-left">TDOC</th>
                    <th class="p-2 text-left">SER</th>
                    <th class="p-2 text-left">NUM</th>
                    <th class="p-2 text-left">N. PAG</th>
                    <th class="p-2 text-left">T. PAGO</th>
                    <th class="p-2 text-left">DESCRIPCIÓN</th>
                    <th class="p-2 text-left">CC</th>
                    <th class="p-2 text-left">ESTADO</th>
                    <th class="p-2 text-left">ORDEN</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(row, index) in rows" :key="index">
                    <tr  >
                        <td class="p-2 border" contenteditable="true" x-text="row.cn"
                            @input="updateField(index, 'cn', $event.target.textContent)"></td>
                        <td class="p-2 border" contenteditable="true" x-text="row.asiento"
                            @input="updateField(index, 'asiento', $event.target.textContent)"></td>
                        <td class="p-2 border" contenteditable="true" x-text="row.asiento_descripcion"
                            @input="updateField(index, 'asiento_descripcion', $event.target.textContent)"></td>
                        <td class="p-2 border" contenteditable="true" x-text="row.debe_soles"
                            @input="updateField(index, 'debe_soles', $event.target.textContent)"></td>
                        <td class="p-2 border" contenteditable="true" x-text="row.haber"
                            @input="updateField(index, 'haber', $event.target.textContent)"></td>
                        <td class="p-2 border" contenteditable="true" x-text="row.debe_dolares"
                            @input="updateField(index, 'debe_dolares', $event.target.textContent)"></td>
                        <td class="p-2 border" contenteditable="true" x-text="row.haber_dolares"
                            @input="updateField(index, 'haber_dolares', $event.target.textContent)"></td>
                        <td class="p-2 border" contenteditable="true" x-text="row.tc"
                            @input="updateField(index, 'tc', $event.target.textContent)"></td>
                        <td class="p-2 border" contenteditable="true" x-text="row.glosa_Especifica"
                            @input="updateField(index, 'glosa_especifica', $event.target.textContent)"></td>
                        <td class="p-2 border" contenteditable="true" x-text="row.razon_social"
                            @input="updateField(index, 'razon_social', $event.target.textContent)"></td>
                        <td class="p-2 border" contenteditable="true" x-text="row.tdoc"
                            @input="updateField(index, 'tdoc', $event.target.textContent)"></td>
                        <td class="p-2 border" contenteditable="true" x-text="row.serie"
                            @input="updateField(index, 'serie', $event.target.textContent)"></td>
                        <td class="p-2 border" contenteditable="true" x-text="row.numero"
                            @input="updateField(index, 'numero', $event.target.textContent)"></td>
                        <td class="p-2 border" contenteditable="true" x-text="row.npag"
                            @input="updateField(index, 'npag', $event.target.textContent)"></td>
                        <td class="p-2 border" contenteditable="true" x-text="row.tpago"
                            @input="updateField(index, 'tpago', $event.target.textContent)"></td>
                        <td class="p-2 border" contenteditable="true" x-text="row.descripcion"
                            @input="updateField(index, 'descripcion', $event.target.textContent)"></td>
                        <td class="p-2 border" contenteditable="true" x-text="row.cc"
                            @input="updateField(index, 'cc', $event.target.textContent)"></td>
                        <td class="p-2 border" contenteditable="true" x-text="row.estado"
                            @input="updateField(index, 'estado', $event.target.textContent)"></td>
                        <td class="p-2 border" contenteditable="true" x-text="row.orden"
                            @input="updateField(index, 'orden', $event.target.textContent)"></td>
                        <!-- Agregar más celdas de la misma forma -->
                    </tr>
                </template>
            </tbody>
        </table>

        <button class="mt-4 bg-teal-600 text-white py-2 px-4 rounded shadow" @click="addRow()">
            Insertar otra fila
        </button>
        <button class="mt-4 bg-green-600 text-white py-2 px-4 rounded shadow" @click="saveRows()">
            Guardar Filas
        </button>
    </x-card>

    <script>
        function asientoManager() {
            return {
                rows: [{
                    cn: '',
                    asiento: '',
                    asiento_descripcion: '',
                    debe_soles: '',
                    haber: '',
                    debe_dolares: '',
                    haber_dolares: '',
                    tc: '',
                    glosa_especifica: '',
                    razon_social: '',
                    tdoc: '',
                    ser: '',
                    num: '',
                    n_pag: '',
                    t_pago: '',
                    descripcion_pago: '',
                    cc: '',
                    estado: '',
                    orden: ''
                }],
                addRow() {
                    this.rows.push({
                        cn: '',
                        asiento: '',
                        asiento_descripcion: '',
                        debe_soles: '',
                        haber: '',
                        debe_dolares: '',
                        haber_dolares: '',
                        tc: '',
                        glosa_especifica: '',
                        razon_social: '',
                        tdoc: '',
                        ser: '',
                        num: '',
                        n_pag: '',
                        t_pago: '',
                        descripcion_pago: '',
                        cc: '',
                        estado: '',
                        orden: ''
                    });
                },
                updateField(index, field, value) {
                    this.rows[index][field] = value;
                },
                saveRows() {
                    // Aquí puedes llamar a un método de Livewire para guardar los datos
                    @this.saveRows(this.rows);
                }
            };
        }
    </script>
</div>
