<input type="hidden" name="{{ $field->getFormFieldName($hash) }}" value="{{ $value->isFalse() ? '0' : '1' }}">
