<div class="form-group">
    <label>
        <?= $this->lang('form', $label); ?>
        <?= $required ? '<span class="required-star">*</span>' : ''; ?>
    </label>
    <input
            type="file"
            class="form-control-file <?= $error ? 'is-invalid' : ''; ?>"
            name="<?= $name; ?>"
        <?= $placeholder ? "placeholder='" . $this->lang('form', $placeholder) . "'" : ''; ?>
        <?= $validator ? "data-validator='{$validator}'" : ''; ?>
        <?= $validatorParams ? "data-validator-params='" . json_encode($validatorParams) . "'" : ''; ?>
        <?= $required ? 'required' : ''; ?>
    />
    <?= $error ? '<div class="invalid-feedback">' . ($this->lang('validator', $error)) . '</div>' : ''; ?>
</div>