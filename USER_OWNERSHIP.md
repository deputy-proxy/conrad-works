# User ownership

All primary personal-domain resources are owned by the authenticated user.

User-owned resources:
- MyRole
- Habit
- WifeMessage
- DaughterMessage
- BookableSlot
- Venture
- Book
- Article
- Course
- Song

Create pages automatically set `user_id` from `auth()->id()`.
List pages scope records to the authenticated user.

Child resources:
- HabitCompletion belongs to Habit.
- Booking belongs to BookableSlot.

These child records should derive authorization/ownership from their parent rather than introducing a second user ownership relationship.
