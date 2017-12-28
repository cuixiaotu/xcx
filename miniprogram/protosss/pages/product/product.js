// pages/product/product.js
import { Product } from "product-model.js";
var product = new Product();

Page({
  data: {
    id : null ,
    countsArray : [1,2,3,4,5,6,7,8,9,10] ,
    productCount : 1
  },
  onLoad: function (options) {
    var id = options.id;
    this.data.id = id ;
    this._loadData();
  },
  _loadData:function(){
    var id = this.data.id;
    product.getDetailInfo(id,(res) => {
      this.setData({
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

  }



})