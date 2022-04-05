import Dialog from '@mui/material/Dialog';
import LogoutIcon from '@mui/icons-material/Logout';
import clsx from 'clsx';
import PropTypes from 'prop-types';
import Button from '@mui/material/Button';

const sizes = {
  sm: 'max-w-md',
  md: 'max-w-xl',
  lg: 'max-w-3xl',
  xl: 'max-w-7xl',
  full: 'max-w-full',
};

export function Drawer({
  title,
  children,
  isOpen,
  onClose,
  renderFooter,
  size,
}) {
  return (
    <Dialog
      as="div"
      static
      className="fixed inset-0 overflow-hidden z-40"
      open={isOpen}
      onClose={onClose}
    >
      <div className="absolute inset-0 overflow-hidden">
        <Dialog.Overlay className="absolute inset-0" />
        <div className="fixed inset-y-0 right-0 pl-10 max-w-full flex">

          <div className={clsx('w-screen', sizes[size])}>
            <div className="h-full divide-y divide-gray-200 flex flex-col bg-white shadow-xl">
              <div className="min-h-0 flex-1 flex flex-col py-6 overflow-y-scroll">
                <div className="px-4 sm:px-6">
                  <div className="flex items-start justify-between">
                    <Dialog.Title className="text-lg font-medium text-gray-900">
                      {title}
                    </Dialog.Title>
                    <div className="ml-3 h-7 flex items-center">
                      <Button
                        className="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        onClick={onClose}
                      >
                        <span className="sr-only">Close panel</span>
                        <LogoutIcon className="h-6 w-6" aria-hidden="true" />
                      </Button>
                    </div>
                  </div>
                </div>
                <div className="mt-6 relative flex-1 px-4 sm:px-6">{children}</div>
              </div>
              <div className="flex-shrink-0 px-4 py-4 flex justify-end space-x-2">
                {renderFooter()}
              </div>
            </div>
          </div>
        </div>
      </div>
    </Dialog>
  );
}

Drawer.propTypes = {
  title: PropTypes.string,
  size: PropTypes.string,
  children: PropTypes.element,
  isOpen: PropTypes.bool,
  onClose: PropTypes.func,
  renderFooter: PropTypes.element,
};

Drawer.defaultProps = {
  title: '',
  size: 'md',
  children: null,
  isOpen: false,
  onClose: () => { },
  renderFooter: null,
};
