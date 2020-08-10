import ThemeWrapper from '../Theme/theme.wrapper';
import { Subscription } from 'rxjs';

export default abstract class VueWrapper extends ThemeWrapper {
    // Properties
    private Subscriptions: Array<Subscription> = [];

    // Getters and Setters
    set AddSubscription$(subscription: Subscription) {
        this.Subscriptions.push(subscription);
    }

    /**
     * Unsubscribes from all the subscriptions
     * (*used in `beforeDestroy` hook of Vue Components)*.
     */
    public unsubscribeSubscriptions() {
        for (const subscription of this.Subscriptions) {
            if (subscription) {
                try {
                    subscription.unsubscribe();
                } catch (err) {
                    alert();
                    console.log(new Error(err));
                }
            }
        }
        if (this.Subscriptions.length > 0) {
            this.Subscriptions.splice(0, this.Subscriptions.length);
        }
    }

    public beforeDestroy() {
        this.unsubscribeSubscriptions();
    }
}
