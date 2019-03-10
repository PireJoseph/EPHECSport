// import React from 'react';
// import ReactDOM from 'react-dom';
//
// import Items from './Components/Items';
//
//
// class App extends React.Component {
//     constructor() {
//         super();
//
//         this.state = {
//             entries: []
//         };
//     }
//
//     componentDidMount() {
//         fetch('https://jsonplaceholder.typicode.com/posts/')
//             .then(response => response.json())
//             .then(entries => {
//                 this.setState({
//                     entries
//                 });
//             });
//     }
//
//     render() {
//         return (
//             <div className="row">
//             {this.state.entries.map(
//                     ({ id, title, body }) => (
//                         <Items
//                 key={id}
//                 title={title}
//                 body={body}
//                 >
//                 </Items>
//     )
//     )}
//     </div>
//     );
//     }
// }
//
// ReactDOM.render(<App />, document.getElementById('root'));

// assets/js/app.js
import Vue from 'vue'
import Vuex from 'vuex'
import VueRouter from 'vue-router'
import Example from './components/Example'

Vue.use(VueRouter)
Vue.use(Vuex)

/**
 * Create a fresh Vue Application instance
 */
new Vue({
    el: '#root',
    components: {Example}
});


