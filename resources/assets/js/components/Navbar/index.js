import React, { Component } from "react";
import { Link } from "react-router-dom";

class Navbar extends Component {
  render() {
    return (
      <nav className="navbar navbar-expand-lg nav-bg">
        <Link to="/members" className="navbar-brand">
          <img
            src="/images/pipservenav.png"
            width="200"
            height="50"
            className="d-inline-block align-top"
          />
        </Link>
        <button
          className="navbar-toggler"
          type="button"
          data-toggle="collapse"
          data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span className="navbar-toggler-icon" />
        </button>

        <div className="collapse navbar-collapse" id="navbarSupportedContent">
          <div className="navbar-nav">
            <Link to="/members" className="nav-link custm-nav-link-text">
              {" "}
              Members{" "}
            </Link>
            <Link to="/clients" className="nav-link custm-nav-link-text">
              {" "}
              Clients{" "}
            </Link>
            <Link to="/reports" className="nav-link custm-nav-link-text">
              {" "}
              Reports{" "}
            </Link>
          </div>

          <ul className="navbar-nav flex-row ml-md-auto d-none d-md-flex">
            <li className="nav-item dropdown" id="nav-user-dropdown">
              <a
                id="users-dd"
                href="#"
                className="nav-item custm-nav-link-text dropdown-toggle mr-md-2"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                Users
              </a>
              <div
                className="dropdown-menu dropdown-menu-right"
                aria-labelledby="users-dd"
              >
                <a href="#" className="dropdown-item">
                  Roles
                </a>
                <a href="#" className="dropdown-item">
                  Permissions
                </a>
              </div>
            </li>
            <li className="nav-item">
              <a href="#" id="navbar-profile-pic">
                <img
                  src="../images/Ella.jpeg"
                  width="45"
                  height="45"
                  className="rounded-circle"
                />
              </a>
            </li>
            <li className="nav-item dropdown">
              <small className="nav-user-name">Daniella C.</small>
              <a>
                <span className="user-group-title">User Group Title</span>
              </a>
            </li>
            <li className="nav-item dropdown" id="right-item-dd">
              <a
                href="#"
                id="right-dd"
                className="nav-item"
                data-toggle="dropdown"
                aria-haspopup="true"
              >
                ▾
              </a>
              <div
                className="dropdown-menu drop-menu-right"
                aria-labelledby="right-dd"
              >
                <h6 className="dropdown-header">Hello, Jerome</h6>
                <div className="dropdown-divider" />
                <a href="#" className="dropdown-item">
                  Profile
                </a>
                <Link to="/settings/status" className="dropdown-item">
                  {" "}
                  User Settings{" "}
                </Link>
                <div className="dropdown-divider" />
                <a href="#" className="dropdown-item">
                  Sign Out
                </a>
              </div>
            </li>
          </ul>
        </div>
      </nav>
    );
  }
}

export default Navbar;
