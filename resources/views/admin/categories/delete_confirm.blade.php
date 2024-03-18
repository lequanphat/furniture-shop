<div class="modal fade" id="delete-category-modal" tabindex="-1" role="dialog" aria-labelledby="deleteEmployeeTittle"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="delete-category-id">Delete Confirmation</h5>
            </div>
            <div class="modal-body ">

                <form id="delete-category-form" action="#" method="dialog">
                    @csrf
                    <input type="text" class="form-control" id="category_id" name="category_id">
                    <div class="mb-3 row">



                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary float-right px-4 mx-2">Delete</button>
                        <button id="js-cancel-delete-category" type="button" class="btn btn-secondary"
                                data-dismiss="modal">Cancel
                        </button>
                    </div>
                </form>

            </div>
    </div>
</div>
