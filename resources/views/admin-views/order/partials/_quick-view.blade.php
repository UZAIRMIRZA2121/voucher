<div class="modal-header p-0">
    <h4 class="modal-title product-title">
    </h4>
    <button class="close call-when-done" type="button" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="d-flex flex-row">
        <!-- Product gallery-->
        <div class="d-flex align-items-center justify-content-center active">
            <img class="img-responsive initial--20 onerror-image"
            src="{{ $product['image_full_url'] }}"
                data-onerror-image="{{asset('assets/admin/img/160x160/img2.jpg') }}"
                data-zoom="{{ asset('storage/app/public/product') }}/{{ $product['image'] }}" alt="Product image"
                width="">
            <div class="cz-image-zoom-pane"></div>
        </div>
        <!-- Product details-->
        <div class="details pl-2">
            <a href="{{ route('admin.item.view', $product->id) }}" class="h3 mb-2 product-title">{{ $product->name }}</a>
            @if (isset($product->module_id) && $product->module->module_type == 'food')
            <div class="mb-3 text-dark">
                <span class="h3 font-weight-normal text-accent mr-1">
                    {{ \App\CentralLogics\Helpers::get_food_price_range($product, true) }}
                </span>
                @if ($product->discount > 0)
                    <strike class="initial--18">
                        {{ \App\CentralLogics\Helpers::get_food_price_range($product) }}
                    </strike>
                @endif
            </div>
            @else
            <div class="mb-3 text-dark">
                <span class="h3 font-weight-normal text-accent mr-1">
                    {{ \App\CentralLogics\Helpers::get_price_range($product, true) }}
                </span>
                @if ($product->discount > 0)
                    <strike class="initial--18">
                        {{ \App\CentralLogics\Helpers::get_price_range($product) }}
                    </strike>
                @endif
            </div>
            @endif

            @if ($product->discount > 0)
                <div class="mb-3 text-dark">
                    <strong>Discount : </strong>
                    <strong
                        id="set-discount-amount">{{ \App\CentralLogics\Helpers::get_product_discount($product) }}</strong>
                </div>
            @endif
            <!-- Product panels-->
            {{-- <div class="sharethis-inline-share-buttons"></div> --}}
        </div>
    </div>
    <div class="row pt-2">
        <div class="col-12">
            <h2>{{ translate('messages.description') }}</h2>
            <span class="d-block text-dark">
                {!! $product->description !!}
            </span>


            @if (in_array($product->module->module_type ,['food','grocery']))
                @if (count($product->nutritions) )
                    <h4 class="mt-2"> {{ translate('messages.Nutrition_Details') }}</h4>
                    <span class="d-block text-dark text-break">
                        @foreach($product->nutritions as $nutrition)
                        {{$nutrition->nutrition}}{{ !$loop->last ? ',' : '.'}}
                        @endforeach
                    </span>
                @endif
                @if (count($product->allergies))
                    <h4 class="mt-2"> {{ translate('messages.Allergie_Ingredients') }}</h4>
                    <span class="d-block text-dark text-break">
                        @foreach($product->allergies as $allergy)
                        {{$allergy->allergy}}{{ !$loop->last ? ',' : '.'}}
                        @endforeach
                    </span>
                @endif
            @endif

            @if (in_array($product->module->module_type ,['pharmacy']))
                @if ($product->generic->pluck('generic_name')->first())
                    <h4 class="mt-2"> {{ translate('generic_name') }}</h4>
                    <span class="d-block text-dark text-break">
                        {{ $product->generic->pluck('generic_name')->first() }}
                    </span>
                @endif
            @endif



            <form id="add-to-cart-form" class="mb-2">
                @csrf
                <input type="hidden" name="id" value="{{ $product->id }}">
                <input type="hidden" name="order_id" value="{{ $order_id }}">
                <input type="hidden" name="item_type" value="{{ $item_type }}">
                @if (isset($product->module_id) && $product->module->module_type == 'food')
                    @if ($product->food_variations)

                        @foreach (json_decode($product->food_variations) as $key => $choice)
                            @if (isset($choice->price) == false)
                                <div class="h3 p-0 pt-2">{{ $choice->name }} <small style="font-size: 12px"
                                        class="text-muted">
                                        ({{ $choice->required == 'on' ? translate('messages.Required') : translate('messages.optional') }})
                                    </small>
                                </div>
                                @if ($choice->min != 0 && $choice->max != 0)
                                    <small class="d-block mb-3">
                                        {{ translate('You_need_to_select_minimum_ ') }} {{ $choice->min }}
                                        {{ translate('to_maximum_ ') }} {{ $choice->max }}
                                        {{ translate('options') }}
                                    </small>
                                @endif

                                <div>
                                    <input type="hidden" name="variations[{{ $key }}][min]"
                                        value="{{ $choice->min }}">
                                    <input type="hidden" name="variations[{{ $key }}][max]"
                                        value="{{ $choice->max }}">
                                    <input type="hidden" name="variations[{{ $key }}][required]"
                                        value="{{ $choice->required }}">
                                    <input type="hidden" name="variations[{{ $key }}][name]"
                                        value="{{ $choice->name }}">
                                    @foreach ($choice->values as $k => $option)
                                        <div class="form-check form--check d-flex pr-5 mr-6">
                                            <input class="form-check-input"
                                                type="{{ $choice->type == 'multi' ? 'checkbox' : 'radio' }}"
                                                id="choice-option-{{ $key }}-{{ $k }}"
                                                name="variations[{{ $key }}][values][label][]"
                                                value="{{ $option->label }}" autocomplete="off">

                                            <label class="form-check-label"
                                                for="choice-option-{{ $key }}-{{ $k }}">{{ Str::limit($option->label, 20, '...') }}</label>
                                            <span
                                                class="ml-auto">{{ \App\CentralLogics\Helpers::format_currency($option->optionPrice) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    @endif
                @else
                    @foreach (json_decode($product->choice_options) as $key => $choice)
                        <div class="h3 p-0 pt-2">{{ $choice->title }}
                        </div>

                        <div class="d-flex justify-content-left flex-wrap">
                            @foreach ($choice->options as $key => $option)
                                <input class="btn-check" type="radio" id="{{ $choice->name }}-{{ $option }}"
                                    name="{{ $choice->name }}" value="{{ $option }}"
                                    @if ($key == 0) checked @endif autocomplete="off">
                                <label class="btn btn-sm check-label mx-1 choice-input"
                                    for="{{ $choice->name }}-{{ $option }}">{{ Str::limit($option, 20, '...') }}</label>
                            @endforeach
                        </div>
                    @endforeach
                @endif

                <!-- Quantity + Add to cart -->
                <div class="d-flex justify-content-between">
                    <div class="product-description-label mt-2 text-dark h3">{{ translate('messages.quantity') }}:
                    </div>
                    <div class="product-quantity d-flex align-items-center">
                        <div class="input-group input-group--style-2 pr-3 initial--19">
                            <span class="input-group-btn">
                                <button class="btn btn-number text-dark p--10" type="button" data-type="minus"
                                    data-field="quantity" disabled="disabled">
                                    <i class="tio-remove  font-weight-bold"></i>
                                </button>
                            </span>
                            <input type="text" name="quantity"
                                class="form-control input-number text-center cart-qty-field" placeholder="1"
                                value="1" min="1" max="100">
                            <span class="input-group-btn">
                                <button class="btn btn-number text-dark p--10" type="button" data-type="plus"
                                    data-field="quantity">
                                    <i class="tio-add  font-weight-bold"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                @php($add_ons = json_decode($product->add_ons))
                @if (count($add_ons) > 0 && $add_ons[0])
                    <div class="h3 p-0 pt-2">{{ translate('messages.addon') }}
                    </div>

                    <div class="d-flex justify-content-left flex-wrap">
                        @foreach (\App\Models\AddOn::withoutGlobalScope(\App\Scopes\StoreScope::class)->whereIn('id', $add_ons)->active()->get() as $key => $add_on)
                            <div class="flex-column pb-2">
                                <input type="hidden" name="addon-price{{ $add_on->id }}"
                                    value="{{ $add_on->price }}">
                                <input class="btn-check addon-chek addon_quantity_input_toggle" type="checkbox" id="addon{{ $key }}" name="addon_id[]"
                                    value="{{ $add_on->id }}" autocomplete="off">
                                <label class="d-flex align-items-center btn btn-sm check-label mx-1 addon-input"
                                    for="addon{{ $key }}">{{ Str::limit($add_on->name, 20, '...') }} <br>
                                    {{ \App\CentralLogics\Helpers::format_currency($add_on->price) }}</label>
                                <label class="input-group addon-quantity-input mx-1 shadow bg-white rounded px-1"
                                    for="addon{{ $key }}">
                                    <button class="btn btn-sm h-100 text-dark px-0 addon-stepup" type="button"><i
                                            class="tio-remove  font-weight-bold"></i></button>
                                    <input type="number" name="addon-quantity{{ $add_on->id }}"
                                        class="form-control text-center border-0 h-100" placeholder="1"
                                        value="1" min="1" max="100" readonly>
                                    <button class="btn btn-sm h-100 text-dark px-0 addon-stepdown" type="button"><i
                                            class="tio-add  font-weight-bold"></i></button>
                                </label>
                            </div>
                        @endforeach
                    </div>
                @endif
                <div class="row no-gutters d-none mt-2 text-dark" id="chosen_price_div">
                    <div class="col-2">
                        <div class="product-description-label">{{ translate('Total Price') }}:</div>
                    </div>
                    <div class="col-10">
                        <div class="product-price">
                            <strong id="chosen_price"></strong>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-2">
                <button class="btn btn--primary h--45px update_order_item" type="button">
                        <i class="tio-shopping-cart"></i>
                        {{ translate('messages.add_to_cart') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{asset('assets/admin')}}/js/view-pages/common.js"></script>
<script type="text/javascript">
    cartQuantityInitialize();
    getVariantPrice();
    $('#add-to-cart-form input').on('change', function() {
        getVariantPrice();
    });
    $('.addon-stepup').on('change', function() {
        this.parentNode.querySelector('input[type=number]').stepDown(), getVariantPrice()
    });
    $('.addon-stepdown').on('change', function() {
        this.parentNode.querySelector('input[type=number]').stepUp(), getVariantPrice()
    });
</script>
