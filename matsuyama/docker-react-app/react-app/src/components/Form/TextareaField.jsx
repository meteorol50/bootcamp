import clsx from 'clsx';

import PropTypes from 'prop-types';
import { FieldWrapper } from './FieldWrapper';

export function TextAreaField(props) {
  const {
    label, className, registration, error,
  } = props;
  return (
    <FieldWrapper label={label} error={error}>
      <textarea
        className={clsx(
          'appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm',
          className,
        )}
        // eslint-disable-next-line react/jsx-props-no-spreading
        {...registration}
      />
    </FieldWrapper>
  );
}

TextAreaField.propTypes = {
  label: PropTypes.string,
  className: PropTypes.string,
  registration: PropTypes.elementType,
  error: PropTypes.string,
};

TextAreaField.defaultProps = {
  label: '',
  className: '',
  registration: null,
  error: '',
};
