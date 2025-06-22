# Changelog - Payment Bundle System

---

**Update 7**

-   Added a 'Back' button to the first participant step in `couple.blade.php` so users can return to the ticket count selection if needed.

**Update 6**

-   UI/UX update: Ticket count selection is now a separate step in `couple.blade.php` and cannot be changed after proceeding to participant selection.

**Update 5**

-   Kept frontend of `couple.blade.php` dynamic, but backend now only processes 2 tickets.
-   Reverted backend (Laravel) logic in `couple-payment.blade.php` and `couple-instruction.blade.php` to only support 2 participants (Peserta 1 & 2).

**Update 4**

-   Updated `couple-payment.blade.php` and `couple-instruction.blade.php` to display and process dynamic participant data and payment amount.

**Update 3**

-   Refactored `couple.blade.php` to support dynamic bundle registration (2-5 participants):
    -   Added ticket count selector and dynamic stepper form for up to 5 participants.
    -   Implemented dynamic validation, search, and navigation for each participant.
    -   Updated hidden form to support up to 5 participants.

---

This changelog documents major changes to the payment bundle registration and payment instruction system in this folder. For details, see commit history or file comments.
