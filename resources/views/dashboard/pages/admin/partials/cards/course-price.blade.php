<div class="card mb-4 price">
    <div class="card-header">
        <i class="icon fa-sharp fa-regular fa-piggy-bank text-primary"></i>
        {{ __('common.price.title').' '.$pl->name }}</div>
    <div class="card-body">
        <x-form.price-fields :price="!empty($course) && !empty($course->getPrice($pl->id))?$course->getPrice($pl->id)->toArray():''" id="{{ $pl->id.'-price' }}" :priceLevelId="$pl->id"></x-form.price-fields>
    </div>
</div>
