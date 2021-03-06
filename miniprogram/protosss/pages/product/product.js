import { Product } from "product-model.js";
import { Cart }    from "../cart/cart-model.js";

var product = new Product();
var cart    = new Cart();

Page({
  data: {
    id : null ,
    countsArray : [1,2,3,4,5,6,7,8,9,10] ,
    productCount : 1,
    currentTabsIndex : 0,
  },
  onLoad: function (options) {
    var id = options.id;
    this.data.id = id ;
    this._loadData();
  },
  _loadData:function(){
    var id = this.data.id;
    console.log(cart.getCartTotalCounts());
    product.getDetailInfo(id,(res) => {
      this.setData({
        cartTotalCounts: cart.getCartTotalCounts(),
         product : res
      });
    })
  },
  bindPickerChange:function(event){
    var index = event.detail.value;
    var selectedCount = this.data.countsArray[index];
    this.setData({
      productCount : selectedCount
    })
  },
  onTabsItemTap:function(event){
    var index = product.getDataSet(event,'index');
    this.setData({
      currentTabsIndex:index
    })
  },
  onAddToCartTap:function(event){
    this.addToCart();

  },
  addToCart:function(){
    var tempObj = {};
    var keys = ['id', 'name', 'main_img_url', 'price'];
    for (var key in this.data.product) {
      if (keys.indexOf(key) >= 0) {
        tempObj[key] = this.data.product[key];
      }
    }
    cart.add(tempObj, this.data.productCount);
  }



})