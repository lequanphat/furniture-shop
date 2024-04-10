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
                    <div>
                        <label for="">Order ID</label>
                        <input id="order_id" type="text" value="{{ $order->order_id }}">
                    </div>
                    <div>
                        <label for="">Reason</label>
                        <textarea name="note" id="note" cols="30" rows="5" required></textarea>
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
