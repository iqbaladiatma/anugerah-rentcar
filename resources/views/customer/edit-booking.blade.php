<x-public-layout>

    <script>
        function toggleOutOfTownFee() {
            const checkbox = document.querySelector('input[name="is_out_of_town"]');
            const feeSection = document.getElementById('out_of_town_fee_section');
            
            if (checkbox.checked) {
                feeSection.style.display = 'block';
            } else {
                feeSection.style.display = 'none';
                document.getElementById('out_of_town_fee').value = '';
            }
        }

        // Ensure end date is after start date
        document.getElementById('start_date').addEventListener('change', function() {
            const startDate = new Date(this.value);
            const endDateInput = document.getElementById('end_date');
            const minEndDate = new Date(startDate.getTime() + 24 * 60 * 60 * 1000); // Add 1 day
            
            endDateInput.min = minEndDate.toISOString().slice(0, 16);
            
            if (new Date(endDateInput.value) <= startDate) {
                endDateInput.value = minEndDate.toISOString().slice(0, 16);
            }
        });
    </script>
</x-public-layout>