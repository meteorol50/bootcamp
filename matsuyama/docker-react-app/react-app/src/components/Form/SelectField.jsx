import clsx from 'clsx';
import PropTypes from 'prop-types';

import { FieldWrapper } from './FieldWrapper';

export function SelectField(props) {
  const {
    label, options, error, className, defaultValue, registration, placeholder,
  } = props;
  return (
    <FieldWrapper label={label} error={error}>
      <select
        placeholder={placeholder}
        name="location"
        className={clsx(
          'mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-600 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md',
          className,
        )}
        defaultValue={defaultValue}
        // eslint-disable-next-line react/jsx-props-no-spreading
        {...registration}
      >
        {options.map((optionValue) => (
          <option key={optionValue.label?.toString()} value={optionValue.value}>
            {label}
          </option>
        ))}
      </select>
    </FieldWrapper>
  );
}

SelectField.propTypes = {
  type: PropTypes.string,
  options: PropTypes.arrayOf(PropTypes.shape({
    label: PropTypes.string,
    value: PropTypes.string,
  })),
  defaultValue: PropTypes.string,
  placeholder: PropTypes.string,
  label: PropTypes.string,
  className: PropTypes.string,
  registration: PropTypes.elementType,
  error: PropTypes.string,
};

SelectField.defaultProps = {
  type: 'text',
  options: [{ label: '', value: '' }],
  defaultValue: '',
  placeholder: '',
  label: '',
  className: '',
  registration: null,
  error: '',
};
