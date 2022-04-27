import React, { useState, useEffect } from "react";
import Drawer from "react-modern-drawer";
import "react-modern-drawer/dist/index.css";
import MenuOutlinedIcon from "@mui/icons-material/MenuOutlined";
import { DrawerIcon } from "./DrawerIcon";
import { DrawerItem } from "./DrawerItem";

export function HeaderDrawer() {
  const [isOpen, setIsOpen] = React.useState(false);
  const toggleDrawer = () => {
    setIsOpen((prevState) => !prevState);
  };

  return (
    <div>
      <div onClick={toggleDrawer}>
        <MenuOutlinedIcon className="hamburger" />
      </div>
      <Drawer open={isOpen} onClose={toggleDrawer} direction="left">
        <DrawerIcon />
        <ul>
          {DrawerItem.map((item, id) => {
            return (
              <>
                <li
                  key={id}
                  className="itemList"
                  onClick={() => {
                    window.location.pathname = item.link;
                  }}
                >
                  <span id="icon" className="itemIcon">
                    {item.icon}
                  </span>
                  <span id="title" className="itemTitle">
                    {item.title}
                  </span>
                </li>
              </>
            );
          })}
        </ul>
      </Drawer>
    </div>
  );
}

export default HeaderDrawer;
