import './bootstrap';

document.addEventListener('alpine:init', () => {
    Alpine.data('currency', (initialValue) => ({
        raw: initialValue,
        
        get formatted() {
            if (this.raw === '' || this.raw === null || this.raw === undefined) return '';
            return new Intl.NumberFormat('id-ID').format(this.raw);
        },
        
        set formatted(value) {
            // Strip non-digits
            let number = value.replace(/\D/g, '');
            this.raw = number;
        }
    }));
});
