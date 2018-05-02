import React from 'react';
import Modal from './Modal';


class ListPost extends React.Component {  
    
    constructor(props) {
    super(props);
    this.handleShowPost = this.handleShowPost.bind(this);
    this.closeForm = this.closeForm.bind(this);
    this.state = { 
        isOpen: false,
        views:  this.props.post.visits
    };
  
    }
     
   closeForm(event){
      event.preventDefault();
            this.setState({
                 isOpen: false,
                
             });
  }   
     
  handleShowPost() {  
    this.setState({
      isOpen: !this.state.isOpen
    });
     $.ajax({
            url: '/app_dev.php/show/data',
             data: { 
               id: this.props.post.id,
             },
            success: function (response) {
       this.setState({
           views: response
       });
            }.bind(this)
        });    
  }
  
  render() {
    return (            
     <div>       
        <Modal show={this.state.isOpen}
                  onClose={this.closeForm}>
            <section className="newPanel">
                <div className="panel-body">            
                    <div className="row m-bot15">
                        <div className="text-center">
                        <h3>{this.props.post.title}</h3>  
                        <span className="badge badge-primary badge-pill">Views: {this.state.views}</span>
                        <p><strong>Title: </strong>{this.props.post.title}</p>
                        <p><strong>Active: </strong>{this.props.post.active}</p>
                        <p><strong>Url: </strong>{this.props.post.url}</p>
                        <p><strong>Date: </strong>{this.props.post.date}</p>    
                        <div dangerouslySetInnerHTML={{__html: this.props.post.text }} />
                        </div>
                    </div>
                </div>
            </section>
        </Modal>  

        <li className="list-group-item d-flex justify-content-between align-items-center">
        <div className="text-right">
        <button  className="btn btn-white" onClick={this.handleShowPost}>Show</button>
        </div>
          <p><strong>Title: </strong>{this.props.post.title}</p><span className="badge badge-primary badge-pill">Views: {this.state.views}</span>
          <p><strong>Active: </strong>{this.props.post.active}</p>
          <p><strong>Url: </strong>{this.props.post.url}</p>
          <p><strong>Date: </strong>{this.props.post.date}</p>    
        </li>            
    </div>    
                );
  }
}



export default ListPost;


