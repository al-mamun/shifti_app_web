import React from 'react';
import {Switch,Route} from 'react-router-dom';
import 'bootstrap/dist/css/bootstrap.min.css';
// import './App.css';

// Home Page Section
import HomePageWeb from './../components/frontend/layouts/master/Master.js'
import Router from "../src/Router";



function App() {
  return (
      <>
      <div className="orpon-bd-web-version-main-section-box">

        <Switch>
          <Route exact path="/" component={HomePageWeb}/>
        </Switch>

      </div>
      </>
  );
}

export default App;


// render((
//     <Router history={browserHistory}>
//         <Route path="/" component={HomePageWeb}/>
//
//     </Router>
// ), document.getElementById('root'));
