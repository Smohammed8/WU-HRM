
// Assuming you've given the select fields IDs: 'employee_category_id' and 'employee_sub_category_id'
$(document).ready(function() {
    $('#employee_category_id').on('change', function() {
        var selectedCategoryId = $(this).val();
        var subCategorySelect = $('#employee_sub_category_id');

        // Make an AJAX request to fetch sub-category options based on the selected category
        $.ajax({
            url: '/admin/employee/fetch-subcategories/' + selectedCategoryId,
            type: 'GET',
            success: function(data) {
                subCategorySelect.empty(); // Clear existing options
                $.each(data, function(id, name) {
                    subCategorySelect.append(new Option(name, id));
                });
            },
        });
    });
});