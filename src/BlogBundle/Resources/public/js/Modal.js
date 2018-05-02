import React from 'react';
import PropTypes from 'prop-types';

class Modal extends React.Component { 
 
    
  render() {
    // Render nothing if the "show" prop is false
    if(!this.props.show) {
      return null;
    }

    return (
      <div className="backendropss" >    
        <div className="modalS scroll" >
        <div className="text-right">
            <div className="btn btn-white" onClick={this.props.onClose}>
              Close
            </div>    
          </div>
          {this.props.children}          
        </div>
      </div>
    );
  }
}

Modal.propTypes = {
  onClose: PropTypes.func.isRequired,
  show: PropTypes.bool,
  children: PropTypes.node
};

export default Modal;