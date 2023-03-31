import React, { Component } from 'react';
import ReactDOM from 'react-dom';
// import Example from "../../../Example";
import TopMenuSection from '../includes/topMenusection/TopMenuSection.js';
// import HomeSliderAndCategory from '../homesliderandcategory/HomeSliderAndCategory.js';
// import FlashDeals from '../allsections/flashdeals/FlashDeals.js';
// import NewArrivalWeb from '../allsections/newarrival/NewArrivalWeb.js';
// import GlobalShoppingWeb from '../allsections/globalshopping/GlobalShoppingWeb.js';
// import BestSellingWeb from '../allsections/bestselling/BestSellingWeb.js';
// import HomeBannerSec from '../allsections/homebannersection/HomeBannerSec.js';
// import TopBrandsSectionWeb from '../allsections/topbrands/TopBrandsSectionWeb.js';
// import HotCategorySecWeb from '../allsections/hotcategory/HotCategorySecWeb.js';
// import MoreToLoveAllProducts from '../allsections/moretoloveallproducts/MoreToLoveAllProducts.js';
// import LatestBlogWeb from '../allsections/latestblogsec/LatestBlogWeb.js';
// import FooterWebSection from '../allsections/footerwebsection/FooterWebSection.js';
// import GroceryZoneSlide from '../allsections/homegroceryzoneslide/GroceryZoneSlide.js';


export default class Master extends Component {
    render() {
        return (
            <>
                <div className="home-page-main-webbb-section-boxxxx-page">

                    <TopMenuSection/>
                    {/*<HomeSliderAndCategory/>*/}
                    {/*<FlashDeals/>*/}
                    {/*<NewArrivalWeb/>*/}
                    {/*<GlobalShoppingWeb/>*/}
                    {/*<GroceryZoneSlide/>*/}
                    {/*<BestSellingWeb/>*/}
                    {/*<HomeBannerSec/>*/}
                    {/*<TopBrandsSectionWeb/>*/}
                    {/*<HotCategorySecWeb/>*/}
                    {/*<MoreToLoveAllProducts/>*/}
                    {/*<LatestBlogWeb/>*/}
                    {/*<FooterWebSection/>*/}

                </div>
            </>
        )
    }
}

if (document.getElementById('root')) {
    ReactDOM.render(<Master />, document.getElementById('root'));
}
