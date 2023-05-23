class Filter {
    stop = false;

    selectors = {
        form: '[data-filter-form]',
        spinner: '[data-filter-spinner]',
        item: '[data-filter-item]',
        container: '[data-filter-results]',
        checkboxDefault: '[data-filter-default]',
    };

    elems = {};

    xhr;

    constructor() {
        this.elems.form = document.querySelector(this.selectors.form);
        this.elems.spinner = document.querySelector(this.selectors.spinner);
        this.elems.container = document.querySelector(this.selectors.container);

        if (this.elems.form !== null && this.elems.spinner !== null && this.elems.container !== null) {
            this.xhrSetup();
            this.addListeners();
        }
    }

    xhrSetup() {
        this.xhr = new XMLHttpRequest();

        this.xhr.onreadystatechange = () => {
            if (this.xhr.readyState === 4 && this.xhr.status === 200) {
                if (this.elems.form.dataset.filterForm === 'recruiting') {
                    this.handlerRecruitForm(this.xhr.responseText);
                } else if (this.elems.form.dataset.filterForm === 'people-partner') {
                    this.handlerPartnerForm(this.xhr.responseText);
                }
            }
        }
    }

    addListeners() {
        this.elems.form.addEventListener('reset', this.stopParser.bind(this));

        this.elems.form.addEventListener('submit', (e) => {
            e.preventDefault();

            this.loadContent();
        });
    }

    loadContent(page = 1) {
        this.spinnerToggle(true);

        const formData = new FormData(this.elems.form);
        formData.append('page', page);

        this.xhr.open('POST', this.elems.form.getAttribute('action'), true);
        this.xhr.send(formData);
    }

    handlerRecruitForm(response) {
        try {
            this.spinnerToggle();

            const data = JSON.parse(response);

            if (data.results.length) {
                for (const key in data.results) {
                    this.elems.container.innerHTML += `
                        <tr>
                            <td><span class="icon-${data.results[key].type}"></span></td>
                            <td><a target="_blank" href="${data.results[key].url}">${data.results[key].text}</a></td>
                            <td>${data.results[key].salary}</td>
                        </tr>
                        `;
                }

                this.loadContent(data.next);
            } else if (document.querySelector('[data-filter-end]') === null) {
                this.elems.container.innerHTML += `
                    <tr data-filter-end>
                        <td colspan="3" class="border-0 text-center">End</td>
                    </tr>
                    `;
            }
        } catch (e) {
            console.log(e);
        }
    }

    handlerPartnerForm(response) {
        try {
            this.spinnerToggle();

            const data = JSON.parse(response);

            if (data.results) {
                for (const type in data.results) {
                    for (const key in data.results[type]) {
                        this.elems.container.innerHTML += `
                        <tr>
                            <td><span class="icon-${type}"></span></td>
                            <td>${key}</td>
                            <td>${data.results[type][key].quartile1}</td>
                            <td>${data.results[type][key].quartile3}</td>
                            <td>${data.results[type][key].median}</td>
                        </tr>
                        `;
                    }
                }
            } else if (document.querySelector('[data-filter-end]') === null) {
                this.elems.container.innerHTML += `
                <tr data-filter-end>
                    <td colspan="5" class="border-0 text-center">No data match your search criteria</td>
                </tr>
                `;
            }
        } catch (e) {
            console.log(e);
        }
    }

    spinnerToggle(visible = false) {
        this.elems.spinner.style.opacity = +!!visible;
    }

    stopParser() {
        this.xhr.abort();
        this.elems.container.innerHTML = '';
        this.spinnerToggle();

        document.querySelectorAll(this.selectors.checkboxDefault).forEach((checkbox) => {
            checkbox.setAttribute('checked', 'checked');
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new Filter();
});
