class Errors {
    // Create and empty arrray of errors
    constructor() {
        this.errors = {};
    }

    // Checks whether any error of specified field exists or not
    has(field) {
        return this.errors.hasOwnProperty(field);
    }

    // Checks if any error exists
    any() {
        return Object.keys(this.errors).length > 0;
    }

    // Get error of a particular field
    get(field) {
        let errorList = "";

        if (this.errors[field]) {
            // return this.errors[field][0];
            this.errors[field].forEach((item, index) => {
                errorList += item;
            });
        }

        return errorList;
    }

    // Record errors
    record(errors) {
        this.errors = errors.errors;
    }

    // Clear an error of specified field
    clear(field) {
        if (field) {
            delete this.errors[field];
            return;
        }

        this.errors = {};
    }
}