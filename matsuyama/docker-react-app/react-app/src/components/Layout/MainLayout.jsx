import Dialog from '@mui/material/Dialog';
import Menu from '@mui/material/Menu';
import HomeIcon from '@mui/icons-material/Home';
import PersonIcon from '@mui/icons-material/Person';
import FolderIcon from '@mui/icons-material/Folder';
import LogoutIcon from '@mui/icons-material/Logout';
import MenuIcon from '@mui/icons-material/Menu';
import clsx from 'clsx';
import * as React from 'react';
import { NavLink, Link } from 'react-router-dom';

import logo from 'assets/icons/logo.svg';

function SideNavigation() {
  // const { checkAccess } = useAuthorization();
  const navigation = [
    { name: 'Dashboard', to: '.', icon: HomeIcon },
    { name: 'Discussions', to: './discussions', icon: FolderIcon },
    // checkAccess({ allowedRoles: [ROLES.ADMIN] }) && {
    //   name: 'Users',
    //   to: './users',
    //   icon: UsersIcon,
    // },
  ].filter(Boolean);

  return (
    <>
      {navigation.map((item, index) => (
        <NavLink
          end={index === 0}
          key={item.name}
          to={item.to}
          className={clsx(
            'text-gray-300 hover:bg-gray-700 hover:text-white',
            'group flex items-center px-2 py-2 text-base font-medium rounded-md',
          )}
          activeClassName="bg-gray-900 text-white"
        >
          <item.icon
            className={clsx(
              'text-gray-400 group-hover:text-gray-300',
              'mr-4 flex-shrink-0 h-6 w-6',
            )}
            aria-hidden="true"
          />
          {item.name}
        </NavLink>
      ))}
    </>
  );
}

function UserNavigation() {
  // const { logout } = useAuth();

  const userNavigation = [
    { name: 'Your Profile', to: './profile' },
    {
      name: 'Sign out',
      to: '',
      onClick: () => {
        // logout();
      },
    },
  ].filter(Boolean);

  return (
    <Menu as="div" className="ml-3 relative">
      {({ open }) => (
        <>
          <div>
            <Menu.Button className="max-w-xs  bg-gray-200 p-2 flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              <span className="sr-only">Open user menu</span>
              <PersonIcon className="h-8 w-8 rounded-full" />
            </Menu.Button>
          </div>
          {/* <Transition
            show={open}
            as={React.Fragment}
            enter="transition ease-out duration-100"
            enterFrom="transform opacity-0 scale-95"
            enterTo="transform opacity-100 scale-100"
            leave="transition ease-in duration-75"
            leaveFrom="transform opacity-100 scale-100"
            leaveTo="transform opacity-0 scale-95"
          > */}
          <Menu.Items
            static
            className="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
          >
            {userNavigation.map((item) => (
              <Menu.Item key={item.name}>
                {({ active }) => (
                  <Link
                    onClick={item.onClick}
                    to={item.to}
                    className={clsx(
                      active ? 'bg-gray-100' : '',
                      'block px-4 py-2 text-sm text-gray-700',
                    )}
                  >
                    {item.name}
                  </Link>
                )}
              </Menu.Item>
            ))}
          </Menu.Items>
          {/* </Transition> */}
        </>
      )}
    </Menu>
  );
}

function MobileSidebar({ sidebarOpen, setSidebarOpen }) {
  return (
    <Dialog
      as="div"
      static
      className="fixed inset-0 flex z-40 md:hidden"
      open={sidebarOpen}
      onClose={setSidebarOpen}
    >
      <Dialog.Overlay className="fixed inset-0 bg-gray-600 bg-opacity-75" />
      <div className="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-gray-800">
        <div className="absolute top-0 right-0 -mr-12 pt-2">
          <button
            className="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
            onClick={() => setSidebarOpen(false)}
          >
            <span className="sr-only">Close sidebar</span>
            <LogoutIcon className="h-6 w-6 text-white" aria-hidden="true" />
          </button>
        </div>
        <div className="flex-shrink-0 flex items-center px-4">
          <Logo />
        </div>
        <div className="mt-5 flex-1 h-0 overflow-y-auto">
          <nav className="px-2 space-y-1">
            <SideNavigation />
          </nav>
        </div>
      </div>
      <div className="flex-shrink-0 w-14" aria-hidden="true" />
    </Dialog>
  );
}

function Sidebar() {
  return (
    <div className="hidden md:flex md:flex-shrink-0">
      <div className="flex flex-col w-64">
        <div className="flex flex-col h-0 flex-1">
          <div className="flex items-center h-16 flex-shrink-0 px-4 bg-gray-900">
            <Logo />
          </div>
          <div className="flex-1 flex flex-col overflow-y-auto">
            <nav className="flex-1 px-2 py-4 bg-gray-800 space-y-1">
              <SideNavigation />
            </nav>
          </div>
        </div>
      </div>
    </div>
  );
}

function Logo() {
  return (
    <Link className="flex items-center text-white" to=".">
      <img className="h-8 w-auto" src={logo} alt="Workflow" />
      <span className="text-xl text-white font-semibold">Bulletproof React</span>
    </Link>
  );
}

export function MainLayout({ children }) {
  const [sidebarOpen, setSidebarOpen] = React.useState(false);

  return (
    <div className="h-screen flex overflow-hidden bg-gray-100">
      <MobileSidebar sidebarOpen={sidebarOpen} setSidebarOpen={setSidebarOpen} />
      <Sidebar />
      <div className="flex flex-col w-0 flex-1 overflow-hidden">
        <div className="relative z-10 flex-shrink-0 flex h-16 bg-white shadow">
          <button
            className="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 md:hidden"
            onClick={() => setSidebarOpen(true)}
          >
            <span className="sr-only">Open sidebar</span>
            <MenuIcon className="h-6 w-6" aria-hidden="true" />
          </button>
          <div className="flex-1 px-4 flex justify-end">
            <div className="ml-4 flex items-center md:ml-6">
              <UserNavigation />
            </div>
          </div>
        </div>
        <main className="flex-1 relative overflow-y-auto focus:outline-none">{children}</main>
      </div>
    </div>
  );
}
