@extends('layouts.app')

@section('content')
    <div class="categories-sec">
        
        {{-- Main Category --}}
        <div id="main-category-container">
            <label class="custom-label">Main Category:</label>
            <select class="form-control" id="main-category">
                <option value="">Select a Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Sub Categories --}}
        <div id="subcategories-container">

        </div>

    </div>

@endsection

@section('scripts')
    <script>
        
        var level = 0;

        $(document).ready(function() {
            
            // listener for main category
            $('#main-category-container').on('change', 'select#main-category', function(){
                let categoryId = $(this).val();
                level = 0;
                newSubCategories(categoryId);
            });

            // listener to the new added sub-categories
            $('#subcategories-container').on('change', '.subcategory-container .subcategory-select', function(){
                let categoryId = $(this).val();
                let levelChanged = $(this).parent().closest('.subcategory-container').data('level');
                newSubCategories(categoryId, levelChanged, true);
            });
        });

        function newSubCategories(categoryId, levelChanged=0, append=false){
            if (categoryId) {
                $.ajax({
                    url: "{{ route('categories.getSubcategories') }}",
                    type: "GET",
                    data: {
                        category_id: categoryId
                    },
                    success: function(response) {
                        existingLevelChanged(levelChanged);
                        generateNewSelectBox(response, categoryId, append);
                    }
                });
            } else {
                existingLevelChanged(levelChanged);
                return;
            }
        }

        function generateNewSelectBox(categories, parentId, append=false){
            
            if(Array.isArray(categories) && ! categories.length > 0){
                return;
            }
            
            level = level+1;

            let html = `<div class="subcategory-container" data-level="${level}">` +
                            `<label class="custom-label">Subcategory [level ${level}]</label>` +
                            `<select class="form-control subcategory-select">` +
                                '<option value="">Select a Sub Category</option>';

            $.each(categories, function(key, subcategory) {
                html += `<option value="${subcategory.id}">${subcategory.name}</option>`;
            });

            html += '</select>';
            html += '</div>';

            // if root is changed we simply replace the content otherwise we append
            if(!append){
                $('#subcategories-container').html(html);
            }else{
                $('#subcategories-container').append(html);
            }
        }

        function existingLevelChanged(levelChanged){
            
            // remove each subcategory container element which level is greater than the changed   
            $('.subcategory-container').each(function(key, div){
                // console.log(div, levelChanged)
                if(levelChanged < $(this).data('level')){
                    $(this).remove();
                }
            })

            // to start again from the same level that triggered the change event
            level = levelChanged;
        }

    </script>
@endsection