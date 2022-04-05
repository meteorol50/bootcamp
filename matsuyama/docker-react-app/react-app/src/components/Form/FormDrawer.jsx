import PropTypes from 'prop-types';

// import { useDisclosure } from 'hooks/useDisclosure';

import Button from '@mui/material/Button';
import { Drawer } from '../Elements/Drawer';

export function FormDrawer({
  title,
  children,
  // eslint-disable-next-line no-unused-vars
  isDone,
  submitButton,
  size = 'md',
}) {
  // const { close, open, isOpen } = useDisclosure();

  // React.useEffect(() => {
  //   if (isDone) {
  //     close();
  //   }
  // }, [isDone, close]);

  return (
    <>
      {/* {React.cloneElement(triggerButton, { onClick: open })} */}
      <Drawer
        isOpen={false}
        // onClose={close}
        title={title}
        size={size}
        renderFooter={() => (
          <>
            <Button variant="outlined" size="sm">
              Cancel
            </Button>
            {submitButton}
          </>
        )}
      >
        {children}
      </Drawer>
    </>
  );
}

FormDrawer.propTypes = {
  title: PropTypes.string,
  children: PropTypes.element,
  isDone: PropTypes.bool,
  submitButton: PropTypes.element,
  size: PropTypes.string,
};

FormDrawer.defaultProps = {
  size: 'md',
  title: '',
  children: null,
  isDone: false,
  submitButton: null,
};
