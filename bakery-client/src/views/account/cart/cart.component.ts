import VueWrapper from '@/components/core/Vue/vue.wrapper';
import { Component } from 'vue-property-decorator';
import { CartItemService, CartItemModel, CoreService } from '@/sdk';

@Component
export default class CartComponent extends VueWrapper {
  public CartItems: Array<CartItemModel> = [];

  // Services
  private CartItemService = CartItemService.Instance;
  private CoreService = CoreService.Instance;

  // Methods
  public created() {
    this.CartItemService.getCartItems();
    this.CartItemService.CartItems.subscribe(Res => {
      this.CartItems = Res;
    });
  }
}
