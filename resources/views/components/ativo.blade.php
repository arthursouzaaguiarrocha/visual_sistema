@props(['value' => true])

<div class="col-12">
    <input type="hidden" name="ativo" value="0">
    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" role="switch" name="ativo" id="ativo" value="1"
               @checked(old('ativo', $value))>
        <label class="form-check-label" for="ativo">Ativo</label>
    </div>
</div>
