
<div class="modal fade" {{--id="discount.delete{{$discount_item->discount_id}}"--}} id="delete_discount_pop" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Delete Discount</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {!! Form::model($discounts, [ 'method' => 'delete','route' => ['discount.delete', $discount_item->discount_id] ]) !!}
                <h4 class="text-center">Are you sure you want to delete Discount?</h4>
                <h5 class="text-center">Discount ID: {{$discount_item->discount_id}} </h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                {{Form::button('<i class="fa fa-trash"></i> Delete', ['class' => 'btn btn-danger', 'type' => 'submit'])}}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
