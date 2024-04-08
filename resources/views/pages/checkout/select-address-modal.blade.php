<div class="modal fade quickview-modal-style" id="select-address-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-title">
                    <h4>My Address</h4>
                </div>
                <div class="address-modal-content">
                    <div class="address-list">
                        @foreach (Auth::user()->addresses as $address)
                            <div class="address-item">
                                <div>
                                    <label class="custom-radio">
                                        <input type="radio" name="myRadio" id="myRadio"
                                            @if ($address->is_default) checked @endif>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div>
                                    <div class="heading">
                                        <p>{{ $address->receiver_name }}</p>
                                        <div class="separate"></div>
                                        <p>{{ $address->phone_number }}</p>
                                    </div>
                                    <p>{{ $address->address }}</p>
                                    @if ($address->is_default)
                                        <div class="default-tag">
                                            Default
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="cancel" data-bs-dismiss="modal">Cancel</button>
                    <button class="js-change-address submit" data-bs-dismiss="modal">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>
