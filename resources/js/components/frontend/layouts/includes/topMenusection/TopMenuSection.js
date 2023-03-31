import React, { Component } from 'react';
import {Link, Redirect} from 'react-router-dom';
import {connect} from 'react-redux';
import './topmenusection.css';

import Modal from 'react-bootstrap/Modal';

// Tabs
import { Tab, Tabs, TabList, TabPanel } from 'react-tabs';
import 'react-tabs/style/react-tabs.css';
import {customerHttp} from "../../../../../ApiServices/customer_http_service";
import Error from "../../../../../ApiServices/ErrorService";
// Tabs

//sweet alert import
import Swal from 'sweetalert2';


import './topmenusection.css';
export default class TopMenuSection extends Component {
    // View More Modal
    constructor(props) {
        super(props);
        this.handleShow = this.handleShow.bind(this);
        this.handleClose = this.handleClose.bind(this);

        this.state = {
            show: false,
            toDashboard: false,
            toVerification: false,
            name: '',
            phone: '',
            email: '',
            password: '',
            i_agree_terms_condition: '',
            errors: {}
        };
    }
    handleClose() {
        this.setState({ show: false });
    }
    handleShow() {
        this.setState({ show: true });
    }
    // View More Modal

    handleRegister = (e) => {
        e.preventDefault();

        const data = {
            name: this.state.name,
            phone: this.state.phone,
            email: this.state.email,
            password: this.state.password,
            i_agree_terms_condition: this.state.i_agree_terms_condition
        };

        customerHttp().post('/customerauth/customer/register', data).then(res => {

            this.props.setRegister(res.data.customer);

            this.setState({
                toVerification: true
            });

            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'User Register Successful!please verify your account',
                showConfirmButton: false,
                timer: 5000
            });

            this.handleClose();

        }).catch(e => {
            this.setState({
                errors: e.response.data.errors
            });

        });

    };

    handleLogin = (e) => {
        e.preventDefault();

        const data = {
            email: this.state.email,
            password: this.state.password
        };

        customerHttp().post('/customerauth/customer/login', data).then(res => {

            localStorage.setItem('customer_token', res.data.token);

            this.props.setLogin(res.data.me.original.data.customer);

            this.setState({
                toDashboard: true
            });

            this.handleClose();


        }).catch(e => {
            this.setState({
                errors: e.response.data.errors
            });

        });
    };

    handleInput = (e) => {
        e.preventDefault();

        const name = e.target.name;
        const value = e.target.value;

        this.setState({
            [name]:value
        })
    };

    render() {

        if (this.state.toVerification === true) {
            return <Redirect to={`/user-otp-confirm/${this.state.phone}`} />
        }

        if (this.state.toDashboard === true) {
            return <Redirect to='/customer-dashboard' />
        }
        return (
            <>
                {/* Top small Menu  */}
                <div className="orpon-bd-main-web-version-topmenu-small-menu-sec">
                    <div className="container">
                        <div className="row">
                            <div className="col-md-5">
                                <div className="orpon-bd-main-web-version-topmenu-small-menu-left-sse">
                                    <p><span><i className="fas fa-phone"></i></span> 01759874611</p>
                                </div>
                            </div>
                            <div className="col-md-7">
                                <div className="orpon-bd-main-web-version-topmenu-small-menu-right-sec text-right">
                                    <ul>
                                        <li><a href="#">Track My Order</a></li>
                                        <li><a href="#">Buyer Protection</a></li>
                                        <li><a href="#">Help</a></li>
                                        <li><a href="#">New App</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {/* Top small Menu */}

                <div className="orpon-bd-main-web-version-topmenu-section">
                    <div className="container">
                        <div className="row orpon-bd-main-web-version-topmenu-section-row-exx-pdd">
                            <div className="col-md-3">
                                <div className="orpon-bd-main-web-version-topmenu-logo-section text-center">
                                    <a href="/">
                                        <img src="http://localhost:8000/frontend/img/logomain.svg" alt="OrponBD Online shop"/>
                                    </a>
                                </div>
                            </div>
                            <div className="col-md-7">
                                <div className="orpon-bd-main-web-version-topmenu-search-box-sec-main">
                                    <div className="orpon-bd-main-web-version-topmenu-serch-cat-sec">
                                        <button>Select Categories <span><i className="fas fa-angle-down"></i></span> </button>
                                    </div>
                                    <div className="orpon-bd-main-web-version-topmenu-search-boxx">
                                        <input type="search" placeholder="Enter Product Name...."/>
                                        <span><button type="submit"><i className="fas fa-search"></i> Search</button></span>
                                    </div>
                                </div>
                            </div>
                            <div className="col-md-2">
                                <div className="orpon-bd-main-web-version-topmenu-search-right-user-signup-sec">
                                    <ul>
                                        <li className="orpon-bd-main-web-version-topmenu-only-sign-in">
                                            <a href="#">
                                                <span><img src="http://localhost:8000/frontend/img/sign-in-profile.png" alt="OrponBD Online shop"/>{!this.props.customerLoggedIn ? (<span>Sign in</span>) : (<span>{this.props.customerName.name.substring(0,5)}</span>)}</span>
                                            </a>

                                            {/* Sign in main box start */}
                                            <div className="orpon-bd-main-web-version-topmenu-signin-register-sec">
                                                <div className="orpon-bd-main-web-version-topmenu-signin-register-btnnx-signinx text-center">
                                                    <button onClick={this.handleShow}>Sign In</button>
                                                </div>
                                                <div className="orpon-bd-main-web-version-topmenu-signin-register-btnnx-registerx text-center">
                                                    <button onClick={this.handleShow}>Join US</button>
                                                </div>

                                                {/* Modal Start */}
                                                <Modal size="sm" show={this.state.show} onHide={this.handleClose}>
                                                    <Modal.Header closeButton></Modal.Header>

                                                    <Modal.Body>
                                                        <div className="orpon-bd-main-web-version-topmenu-signin-register-logo-modal-img text-center">
                                                            <img src='http://localhost:8000/frontend/img/signin-logo-img.png' alt="OrponBD Online shop"/>
                                                        </div>

                                                        <Tabs className="sometexttt">
                                                            <div className="obd-tab-section-flash-deal-detailsonly-tabbss-webx text-center">
                                                                <TabList>
                                                                    <Tab>Sign In</Tab>
                                                                    <Tab>Join Us</Tab>
                                                                </TabList>
                                                            </div>
                                                            <TabPanel>
                                                                <div className="obd-customer-main-user-login-form-main-sec">
                                                                    <form onSubmit={this.handleLogin}>

                                                                        <div className="text-center">
                                                                            <Error error={this.state.errors['result'] ? this.state.errors['result'] : ''}/>
                                                                        </div>

                                                                        <div className="obd-customer-dashboard-user-login-form-main-sec-content">

                                                                            <div className="obd-customer-signin-dashboard-user-login-form-input-field">
                                                                                <input type="text" name="email" onChange={this.handleInput} placeholder="Enter your email or Phone"/>
                                                                                <Error error={this.state.errors['email'] ? this.state.errors['email'] : ''}/>
                                                                            </div>

                                                                            <div className="obd-customer-signin-dashboard-user-login-form-input-field">
                                                                                <input type="password" name="password" onChange={this.handleInput} placeholder="Enter your password"/>
                                                                                <Error error={this.state.errors['password'] ? this.state.errors['password'] : ''}/>
                                                                            </div>

                                                                            <div className="obd-customer-dash-user-login-form-secx text-left">
                                                                                <input type="checkbox"/><span>Remember Me</span>
                                                                                <a href="/customer-forget-password">Forget your password?</a>
                                                                            </div>

                                                                            <div className="obd-customer-dashboard-user-login-form-signin-btnx">
                                                                                <button type="submit">Sign In</button>
                                                                            </div>

                                                                            <div className="obd-customer-dashboard-user-login-orr-social-section text-center">
                                                                                <div className="obd-customer-dashboard-user-login-orr-social-or">
                                                                                    <p>Or</p>
                                                                                    <h3>Login with</h3>
                                                                                </div>
                                                                                <div className="obd-customer-dashboard-user-login-orr-social-social-icon">
                                                                                    <ul>
                                                                                        <li className="obd-customer-login-orr-social-icon-ggl"><a href=""><i class="fab fa-google"></i></a></li>
                                                                                        <li className="obd-customer-login-orr-social-icon-fb"><a href=""><i class="fab fa-facebook-f"></i></a></li>
                                                                                        <li className="obd-customer-login-orr-social-icon-ttr"><a href=""><i class="fab fa-twitter"></i></a></li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </TabPanel>

                                                            <TabPanel>
                                                                <div className="obd-customer-main-user-login-form-main-sec">
                                                                    <form onSubmit={this.handleRegister}>
                                                                        <div className="obd-customer-dashboard-user-login-form-main-sec-content">

                                                                            <div className="obd-customer-signin-dashboard-user-login-form-input-field">
                                                                                <input type="text" name="name" onChange={this.handleInput} placeholder="Enter your Name"/>
                                                                                <Error error={this.state.errors['name'] ? this.state.errors['name'] : ''}/>
                                                                            </div>

                                                                            <div className="obd-customer-signin-dashboard-user-login-form-input-field">
                                                                                <input type="text" name="phone" onChange={this.handleInput} placeholder="Enter your Phone Number"/>
                                                                                <Error error={this.state.errors['phone'] ? this.state.errors['phone'] : ''}/>
                                                                            </div>

                                                                            <div className="obd-customer-signin-dashboard-user-login-form-input-field">
                                                                                <input type="email" name="email" onChange={this.handleInput} placeholder="Enter your email"/>
                                                                                <Error error={this.state.errors['email'] ? this.state.errors['email'] : ''}/>
                                                                            </div>

                                                                            <div className="obd-customer-signin-dashboard-user-login-form-input-field">
                                                                                <input type="password" name="password" onChange={this.handleInput} placeholder="Enter your password"/>
                                                                                <Error error={this.state.errors['password'] ? this.state.errors['password'] : ''}/>
                                                                            </div>

                                                                            <div className="obd-customer-dash-user-login-form-secxz text-left">
                                                                                <input type="checkbox" name="i_agree_terms_condition" onChange={this.handleInput} /><span>I agree to <strong>Orpon BD</strong> <span><a href="">Terms of use</a></span> and <span><a href="">Privacy Policy</a></span></span>
                                                                                a
                                                                            </div>

                                                                            <div className="obd-customer-dashboard-user-login-form-signin-btnx">
                                                                                <button type="submit">Create Account</button>
                                                                            </div>

                                                                            <div className="obd-customer-dashboard-user-login-orr-social-section text-center">
                                                                                <div className="obd-customer-dashboard-user-login-orr-social-or">
                                                                                    <p>Or</p>
                                                                                    <h3>Join us using</h3>
                                                                                </div>
                                                                                <div className="obd-customer-dashboard-user-login-orr-social-social-icon">
                                                                                    <ul>
                                                                                        <li className="obd-customer-login-orr-social-icon-ggl"><a href=""><i class="fab fa-google"></i></a></li>
                                                                                        <li className="obd-customer-login-orr-social-icon-fb"><a href=""><i class="fab fa-facebook-f"></i></a></li>
                                                                                        <li className="obd-customer-login-orr-social-icon-ttr"><a href=""><i class="fab fa-twitter"></i></a></li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </TabPanel>

                                                        </Tabs>
                                                    </Modal.Body>

                                                </Modal>
                                                {/* Modal End*/}

                                                <div className="orpon-bd-main-web-version-topmenu-signin-register-menu-item-box">
                                                    <ul>
                                                        <li><a href="#">My Order</a></li>
                                                        <li><a href="#">My Wishlist</a></li>
                                                        <li><a href="#">My Coupons</a></li>
                                                        <li><a href="#">My Wallet</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            {/* Sign in main box end */}
                                        </li>
                                        <li className="orppon-bd-cart-web-abb-sec">
                                            <a href="/my-cart">
                                                <img src='http://localhost:8000/frontend/img/cart-main.png' alt="OrponBD Online shop"/> <span>10</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Menu and Category Section start */}
                <div className="orpon-bd-main-web-version-topmenu-menu-and-category-section-box">
                    <div className="container">
                        <div className="row orpon-bd-main-web-version-topmenu-menu-extrra-bbtn-ctg">
                            <div className="col-md-3 home-cat-mainn-bbtn-hmmm-ppdf">
                                <div className="category-dropdownn-main-webb-wrap-ctt">
                                    <div className="orpon-bd-main-web-version-topmenu-onlyy-web-category">
                                        <button>Categories <span><i className="fas fa-angle-down"></i></span></button>
                                    </div>
                                    <div className="category-dropdownn-main-webb-cat-content">
                                        <ul>
                                            <li><a href="#">Category Name 1</a></li>
                                            <li><a href="#">Category Name 2 Category Name 3 Category Name 3</a></li>
                                            <li><a href="#">Category Name 3</a></li>
                                            <li><a href="#">Category Name 4</a></li>
                                            <li><a href="#">Category Name 5</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div className="col-md-9">
                                <div className="orpon-bd-main-web-version-topmenu-onlyy-mennnu-web-section">
                                    <ul>
                                        <li><a href="">Home</a></li>
                                        <li><a href="">Why Shop With Us</a></li>
                                        <li><a href="">11.11 Mega Sale</a></li>
                                        <li><a href="/contact-us">Contact Us</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {/* Menu and Category Section end */}
            </>
        )
    }
}
