import VueWrapper from '@/components/core/Vue/vue.wrapper';
import { Component } from 'vue-property-decorator';
import {
  ProductCategoryModel,
  ProductService,
  ProductModel,
  CartItemApi,
  LoaderService,
  CoreService,
  CartItemService
} from '@/sdk';

@Component
export default class ProductsComponent extends VueWrapper {
  //Properties
  public ProductCategories: Array<ProductCategoryModel> = [];
  public Products: Array<ProductModel> = [];

  // Services
  private ProductService = ProductService.Instance;
  private CartItemService = CartItemService.Instance;

  // Methods
  public created() {
    this.ProductService.getProductCategories();
    this.AddSubscription$ = this.ProductService.ProductCategories.subscribe(
      Res => {
        this.ProductCategories = Res;
        if (Res.length) {
          this.ProductService.getProducts();
        }
      }
    );
    this.AddSubscription$ = this.ProductService.Products.subscribe(Res => {
      this.Products = Res;
    });
  }
}
