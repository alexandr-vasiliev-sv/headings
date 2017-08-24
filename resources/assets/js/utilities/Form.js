import Errors from './Errors';

class Form
{
    /**
     *
     * @param data
     */
    constructor(data) {
        this.isSubmitting = false;
        this.originalData = data;
        this.showNotofication = true;

        for (let field in data) {
            this[field] = data[field];
        }
        this.errors = new Errors();
    }

    /**
     *
     */
    reset() {
        for (let field in this.originalData) {
            this[field] = this.originalData[field];
        }
        this.errors.clear();
    }

    /**
     *
     * @returns {{}}
     */
    data() {
        let data = {};

        for (let property in this.originalData) {
            data[property] = this[property];
        }
        return data;
    }

    /**
     *
     * @param url
     * @param resetFrom
     * @returns {Promise}
     */
    post(url, resetFrom = true) {
        return this.submit('post', url, resetFrom);
    }

    /**
     *
     * @param url
     * @param resetFrom
     * @returns {Promise}
     */
    put(url, resetFrom = true) {
        return this.submit('put', url, resetFrom);
    }

    /**
     *
     * @param requestType
     * @param url
     * @param resetForm
     * @returns {Promise}
     */
    submit(requestType, url, resetForm) {
        this.isSubmitting = true;
        return new Promise((resolve, reject) => {
            axios[requestType](url, this.data())
                .then(response => {
                    this.onSuccess(response.data, resetForm);

                    if (response.data.message) {
                        alert(response.data.message);
                    }

                    resolve(response.data);
                })
                .catch(error => {
                    this.onFail(error.response.data);

                    if (error.response.status === 401) {
                        alert('Auth required');
                    }
                    reject(error.response);
                });
        });
    }

    set(field, value) {
        this[field] = value;
    }

    /**
     *
     * @param data
     * @param resetForm
     */
    onSuccess(data, resetForm) {
        this.isSubmitting = false;
        if (resetForm === true) {
            this.reset();
        }
    }

    /**
     *
     * @param errors
     */
    onFail(errors) {
        this.isSubmitting = false;
        this.errors.records(errors)
    }
}

export default Form;