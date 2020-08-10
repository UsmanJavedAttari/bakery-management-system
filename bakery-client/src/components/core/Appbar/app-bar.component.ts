import { Component } from 'vue-property-decorator';
import VueWrapper from '../Vue/vue.wrapper';
import { CoreService, CartItemService } from '@/sdk';

@Component
export default class AppBarComponent extends VueWrapper {
  // Computed Properties
  get CartItemsCount(): string {
    const count = +this.CartService.CartItemsCount.value.NumberOfItems;
    if (count > 9) {
      return '9+';
    }
    return `${count}`;
  }

  // Service
  private CoreService = CoreService.Instance;
  private CartService = CartItemService.Instance;

  // Methods
  public created() {
    this.CartService.getCartItemsCount();
  }
}
