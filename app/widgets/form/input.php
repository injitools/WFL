<div class="form-group">
    <label>
        <?= $this->lang('form', $label); ?>
        <?= $required ? '<span class="required-star">*</span>' : ''; ?>
    </label>
    <input
            type="<?= $type; ?>"
            class="form-control <?= $error ? 'is-invalid' : ''; ?>"
            name="<?= $name; ?>"
        <?= $placeholder ? "placeholder='" . $this->lang('form', $placeholder) . "'" : ''; ?>
        <?= $validator ? "data-validator='{$validator}'" : ''; ?>
        <?= $validatorParams ? "data-validator-params='" . json_encode($validatorParams) . "'" : ''; ?>
        <?= $required ? 'required' : ''; ?>
        <?= $value ? "value='{$value}'" : ''; ?>
    />
    <?= $error ? '<div class="invalid-feedback">' . ($this->lang('validator', $error)) . '</div>' : ''; ?>
</div>