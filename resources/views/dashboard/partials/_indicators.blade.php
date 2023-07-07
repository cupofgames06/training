<div class="card" style="height: 100%">
    <div class="card-body">
        <div class="d-flex justify-content-between pb-4">
            <h4>Suivi spécifique</h4>
        </div>
        <div class="row">
            @foreach($items as $k => $v)
                <div class="col-6 p-2">
                    <div class="card border border-muted indicator">
                        <div class="card-body">
                            <p class="title">{{ \App\Models\Indicator::find($k)->name }}</p>
                            <p class="units">{{ number_format($v) }} {{ \App\Models\Indicator::find($k)->unit }}</p>
                            <div class="progress progress-striped active" role="progressbar" aria-label="Basic example" aria-valuenow="{{ $v }}" aria-valuemin="0" aria-valuemax="{{ \App\Models\Indicator::find($k)->objective }}">
                                <div class="progress-bar" pourcent="{{ $v }}%" ></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        $(".progress-bar").each(function(){
            console.log('ici');
            const pourcent = $(this).attr("pourcent");
            $(this).animate({ width: pourcent }, 1000);
        })
    });
</script>
