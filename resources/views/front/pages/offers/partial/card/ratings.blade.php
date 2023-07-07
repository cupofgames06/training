<div class="card mb-4 bg-secondary aside-summary">
    <div class="card-body">
        <div class="pb-3 title text-white">
            Validations et Evaluations
        </div>
        <div class="card rounded-3 bg-opacity-1 mb-4" >
            <div class="card-body" style="padding: 15px">
                <div class="d-flex flex-wrap justify-content-between">
                    <span class="text-white">Validations pré-requis</span>
                    <span class="badge text-white bg-opacity-1 rounded-4 d-flex justify-content-center align-items-center">A faire</span>
                </div>
            </div>
        </div>
        <div class="card rounded-3 bg-opacity-1 mb-4" >
            <div class="card-body" style="padding: 15px">
                <div class="d-flex flex-wrap justify-content-between">
                    <span class="text-white">Validations acquis</span>
                    <span class="badge text-white bg-opacity-1 rounded-4 d-flex justify-content-center align-items-center">A faire</span>
                </div>
            </div>
        </div>
        <div class="card rounded-3 bg-opacity-1">
            <div class="card-body" style="padding: 15px">
                <div class="d-flex flex-wrap justify-content-between">
                    <span class="text-white">Evaluations formations</span>
                    @if($learner->averageRating() !==  null)
                        <span class="badge text-white bg-opacity-1 rounded-4 d-flex justify-content-center align-items-center">{{ $learner->averageRating($course).'/10' }}</span>
                    @else
                        <span class="badge text-white bg-opacity-1 rounded-4 d-flex justify-content-center align-items-center">A faire</span>
                    @endisset

                </div>
            </div>
        </div>
    </div>
</div>
