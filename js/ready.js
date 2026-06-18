            $(document).ready(function() {
                $('#categories').change(function() {
                    $.ajax({
                        type: 'POST',
                        data: {categories: $(this).val()},
                        url: 'select_product.php',
                        success: function(data) {
                            $('#products').html(data);
                        }
                    });
                    return false;
                });
            });