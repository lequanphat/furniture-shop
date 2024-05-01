<div class="modal fade quickview-modal-style" id="cancel-order-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <form id="cancel-order-form" action="/myorders/{{ $order->order_id }}" class="modal-body">
                @csrf
                @method('PATCH')
                <div class="modal-title">
                    <h4>CANCEL ORDER</h4>
                </div>
                <div class="cancel-order-content">
                    <h4>Are you sure you want to cancel this order?</h4>
                    <div>
                        <label for="">Order: <strong>#{{ $order->order_id }}</strong></label>
                        <input id="order_id" type="text" value="{{ $order->order_id }}" class="d-none">
                    </div>
                    <div>
                        <label for="reason">What is the reason you want to cancel tihs order?</label>
                        <textarea name="reason" id="reason" cols="30" rows="5" required></textarea>
                    </div>

                </div>
                <div class="modal-footer">

                    <button type="button" class="cancel" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="submit">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>
