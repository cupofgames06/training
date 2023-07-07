<div class="footer">

    <div class="d-flex justify-content-between flex-row">
        <div class="d-flex flex-column align-items-start">
            <img src="{{ asset('images/'.get_domain().'/logo.svg') }}" alt="" style="height:50px; width:auto">
        </div>
        <div>
            <ul>
                <li>A propos</li>
                <li>Contact</li>
                <li>Mentions légales</li>
            </ul>
        </div>
        <div class="d-flex flex-column">
            <h2>Restez informé(e)</h2>
            <form class="row g-3">
                <div class="col-auto">
                    <label for="address-email" class="visually-hidden">E-mail</label>
                    <input type="email" class="form-control" id="address-email" placeholder="E-mail">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-secondary mb-3">S'inscrire</button>
                </div>
            </form>

        </div>
    </div>

    <div class="separator my-2"></div>
    <div class="d-flex flex-row justify-content-between mt-4">
        <div>
            <span class="text-muted">&copy; {{ date("Y") }} Meelk - Global Brain</span>
        </div>
        <div>
            <a href="#" class="text-muted text-decoration-none me-3">CGU</a>
            <a href="#" class="text-muted text-decoration-none me-3">Politique de cookies</a>
            <a href="#" class="text-muted text-decoration-none">Politique de confidentialité</a>
        </div>
    </div>
</div>
