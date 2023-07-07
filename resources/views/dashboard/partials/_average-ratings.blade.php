<div class="card bg-secondary" style="height: 100%">
    <div class="card-body">
        <div class="d-flex justify-content-between pb-4">
            <h4 class="text-white">Moyenne des évaluations</h4>
        </div>
        <div class="card rounded-4 bg-opacity-1 mb-4">
            <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between">
                    <span class="text-white">Validations pré-requis</span>
                    <span class="badge text-white bg-opacity-1 rounded-4 d-flex justify-content-center align-items-center">30%</span>
                </div>
            </div>
        </div>
        <div class="card rounded-4 bg-opacity-1 mb-4">
            <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between">
                    <span class="text-white">Validations acquis</span>
                    <span class="badge text-white bg-opacity-1 rounded-4 d-flex justify-content-center align-items-center">30%</span>
                </div>
            </div>
        </div>
        <div class="card rounded-4 bg-opacity-1">
            <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between">
                    <span class="text-white">Evaluations formations</span>
                    <span class="badge text-white bg-opacity-1 rounded-4 d-flex justify-content-center align-items-center">{{ $item->averageRating(from: $from,to: $to)??'- ' }}/10</span>
                </div>
            </div>
        </div>
    </div>
</div>
