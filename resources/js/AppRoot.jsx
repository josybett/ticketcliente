import React, { Component } from 'react';
import Urls from './url';
import { ToastContainer } from 'react-toastify';

class AppRoot extends Component {
  render() {
    return (
      <div>
        <Urls/>
        <ToastContainer
          position="top-center"
          autoClose={5000}
          hideProgressBar={false}
          newestOnTop={false}
          closeOnClick
          rtl={false}
          pauseOnFocusLoss
          draggable
          pauseOnHover
        />
      </div>
    );
  }
}

export default AppRoot;