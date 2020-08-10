import { RouteConfig } from 'vue-router';
import AccountComponent from '../account.component';
import ProfileComponent from '../profile/profile.component';
import ProductsComponent from '../products/products.component';
import CartComponent from '../cart/cart.component';
import PaymentInvoicesComponent from '../payment-invoices/payment-invoices.component';
import PaymentComponent from '../payment/payment.component';

export const AccountRoutes: Array<RouteConfig> = [
  {
    path: '/account',
    component: AccountComponent,
    redirect: '/account/products',
    children: [
      {
        path: 'products',
        name: 'Products',
        component: ProductsComponent
      },
      {
        path: 'cart',
        name: 'Cart',
        component: CartComponent
      },
      {
        path: 'payment-invoices',
        name: 'Payment Invoices',
        component: PaymentInvoicesComponent
      },
      {
        path: 'payment',
        name: 'Payment',
        component: PaymentComponent
      },
      {
        path: 'profile',
        name: 'Profile',
        component: ProfileComponent
      }
    ]
  }
];
