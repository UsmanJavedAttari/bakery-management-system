import VueWrapper from '@/components/core/Vue/vue.wrapper';
import { Component } from 'vue-property-decorator';
import {
  UserService,
  CartItemService,
  PaymentAccountModel,
  CartItemModel
} from '@/sdk';

@Component
export default class PaymentComponent extends VueWrapper {
  // Properties
  public PaymentAccount: string | null = null;
  public PaymentAccounts: Array<PaymentAccountModel> = [];
  public CartItems: Array<CartItemModel> = [];
  public TotalAmount = 0;

  // Services
  private UserService = UserService.Instance;
  private CartItemService = CartItemService.Instance;

  // Methods
  public created() {
    this.UserService.getPaymentAccounts();
    this.UserService.PaymentAccounts.subscribe(Res => {
      this.PaymentAccounts = Res;
    });

    this.CartItemService.getCartItems();
    this.CartItemService.CartItems.subscribe(Res => {
      this.CartItems = Res;
    });

    this.CartItemService.getTotalAmount();
    this.CartItemService.TotalAmount.subscribe(Res => {
      this.TotalAmount = Res;
    });
  }
}
