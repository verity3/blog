import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import moment from 'moment';
import PropTypes from 'prop-types';
import ListPost from './ListPost';
//moment.locale('bg'); 
require('../css/blogs.css');
        
class BlogsComponent extends React.Component {
    
  constructor(props) {
    super(props);
    
    this.state = {
      error: null,
      isLoaded: false,
      posts: [],
      page: 1,
      pageCount: 0,
      showLoadMore: false,
      
    };
    
      
    this.handleLoadMore = this.handleLoadMore.bind(this);
    this.loadPost = this.loadPost.bind(this);
  }
  

 
  
  handleLoadMore(event){
    event.preventDefault();
    var page = Number(this.state.page);
    if(this.state.pageCount){
      if(page > 0 && page < this.state.pageCount){
          page = page + 1;
          this.loadPost(page);
      }else{
          this.setState({
              showLoadMore: false
          })
      }
    }
  }
  
  loadPost(page){      
       $.ajax({
            url: '/app_dev.php/check/data.json',
             data: { 
               page: page,
             },
            success: function (response) {
              var responseArray = [...this.state.posts, ...response.posts];	
       this.setState({
           isLoaded: true,
           posts: responseArray,
           page: response.page,
           pageCount: response.pageCount
       })
      
       if(!(response.pageCount > 1) && response.pageCount == response.page){
           this.setState({
              showLoadMore: false
          })
       }else if(response.pageCount > 1){
            this.setState({
              showLoadMore: true
          })
       }
            }.bind(this)
        });
  } 

  componentDidMount() {  
        this.loadPost(this.state.page);    
  } 

  render() {
    const { error, isLoaded, posts, showLoadMore } = this.state;
  
    const style = {
        
    };
    if (error) {
      return <div>Error: {error.message}</div>;
    } else if (!isLoaded) {
      return <div>Loading...</div>;
    } else {
      return (
    <div >
    
        <div className="col-md-12">
        <div className="chat-conversation">
        
        <ul className="list-group">
          {posts.map((item, key) => (
               <ListPost key={key} post={item}  />     
           
          ))}
        </ul>
    {posts.length < 1  &&
        <ul>
            <li>
                    <div className="conversation-text no-posts text-center" >                        
                        <h5>No posts</h5>
                    </div>
            </li>
        </ul>
    }
    </div>
      {posts.length > 0  &&
  
    <div>  
     {showLoadMore  &&
    <span className="text-center" >
            <a className="btn btn-primary" href="#" onClick={this.handleLoadMore}>
               Load more
            </a>
    </span>    
     }
    </div>
   }
    </div>    
 </div>
      );
    }
  }  
}

const checkout = document.getElementById('blogs');
if (checkout) {
  try {
    ReactDOM.render(
      <BlogsComponent {...(checkout.dataset)}/>,
      checkout
    );
  } catch (error) {
    console.error(error);
  }
}


