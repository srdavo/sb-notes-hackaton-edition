export class DynamicTable {
    constructor(config){
        this.container = config.container;
        this.apiUrl = config.apiUrl;
        this.apiOperation = config.apiOperation;
        this.columns = config.columns || [];
        this.filters = config.filters || {};
        this.additionalParams = config.additionalParams || {}; // NUEVO: parámetros adicionales
        this.buildTableFunction = config.buildTableFunction || this._buildTable.bind(this);

        this._setupEventListeners();
    }

    _setupEventListeners() {
        Object.values(this.filters).forEach(filter => {
            if (filter instanceof HTMLElement) {
                filter.addEventListener("change", () => this.displayData());
            }
        });
    }

    _getFilters() {
        const filterValues = {};
        for (const key in this.filters) {
            const filter = this.filters[key];

            if (filter instanceof HTMLElement) {
                filterValues[key] = filter.value;
            } else if (typeof filter === 'function') {
                filterValues[key] = filter();
            } else if (filter !== undefined && filter !== null) {
                filterValues[key] = filter;
            }
        }
        return filterValues;
    }

    _getVisibleColumnKeys() {
        const keys = this.columns.filter(col => col.visible || col.required).map(col => col.key);
        return [...new Set(keys)];
    }

    // NUEVO: Método para actualizar parámetros adicionales
    updateParams(newParams) {
        this.additionalParams = {
            ...this.additionalParams,
            ...newParams
        };
    }

    // NUEVO: Método para reemplazar completamente los parámetros adicionales
    setParams(params) {
        this.additionalParams = params;
    }

    // NUEVO: Método para limpiar un parámetro específico
    removeParam(key) {
        delete this.additionalParams[key];
    }

    async displayData(page = 0) {
        let apiResult = null;

        const fetchDataAndCapture = async (data) => {
            const result = await request(data);
            apiResult = result;
            return result;
        };

        const data = {
            API_URL: this.apiUrl,
            op: this.apiOperation,
            page,
            ...this._getFilters(),
            ...this.additionalParams, // NUEVO: agregar parámetros adicionales
            columns: this._getVisibleColumnKeys(),
        };

        await displayAnyTable(
            page,
            this.container,
            fetchDataAndCapture,
            (d) => this.buildTableFunction(d),
            {
                paginationFunction: (p) => this.displayData(p),
                ...data
            }
        );

        return apiResult;
    }

    _buildTable(data) {
        const rows = [];
        const visibleColumns = this.columns.filter(c => c.visible);

        if (!data || data.length === 0) {
            const row = document.createElement("div");
            row.className = "content-box align-center border-radius-16 justify-center user-select-none";
            row.innerHTML = `<span class="body-large outline-text">No hay resultados</span>`;
            return [row];
        }

        const header = document.createElement("tr");
        visibleColumns.forEach(column => {
            const th = document.createElement("td");
            th.innerHTML = column.label;
            header.appendChild(th);
        });
        rows.push(header);

        data.forEach(item => {
            const row = document.createElement("tr");
            visibleColumns.forEach(column => {
                const td = document.createElement("td");
                td.innerHTML = column.render(item);
                row.appendChild(td);
            });
            rows.push(row);
        });

        return rows;
    }
}