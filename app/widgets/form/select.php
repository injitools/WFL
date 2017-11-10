<div class="form-group">
    <label>
        <?= $this->lang('form', $label); ?>
        <?= $required ? '<span class="required-star">*</span>' : ''; ?>
    </label>
    <select
            type="<?= $type; ?>"
            class="form-control <?= $error ? 'is-invalid' : ''; ?>"
            name="<?= $name; ?>"
        <?= $placeholder ? "placeholder='" . $this->lang('form', $placeholder) . "'" : ''; ?>
        <?= $validator ? "data-validator='{$validator}'" : ''; ?>
        <?= $validatorParams ? "data-validator-params='" . json_encode($validatorParams) . "'" : ''; ?>
        <?= $required ? 'required' : ''; ?>
    >
        <?php
        foreach ($values as $key => $label) {
            $selected = $key == $value ? 'selected' : '';
            echo "<option value='{$key}' {$selected}>" . $this->lang('form', $label) . "</option>";
        }
        ?>
    </select>
    <?= $error ? '<div class="invalid-feedback">' . ($this->lang('validator', $error)) . '</div>' : ''; ?>
</div>