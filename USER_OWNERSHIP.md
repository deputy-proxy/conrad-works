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

The shared `OwnedResource` base class scopes every resource query to the authenticated user. It fails closed when no user is authenticated or when a resource model has no recognized ownership path. This applies to list queries and record lookups used by edit/delete actions, including direct record URLs.

The shared `OwnedResourcePolicy`, explicitly registered for every resource model in `AppServiceProvider`, applies the same ownership rule to view, update, and delete authorization. Create and list access require an authenticated Filament session; the public registration route remains disabled. Bulk delete authorization relies on the same owner-scoped resource query.

Create pages set `user_id` from the authenticated user, and the models also fill a missing owner on creation. Owner fields are not editable through Filament.

Child resources derive authorization and query ownership from their parent rather than introducing a second user ownership relationship:
- `HabitCompletion` belongs to `Habit`.
- `Booking` belongs to `BookableSlot`.

Their parent selectors only expose records owned by the authenticated user, and server-side validation requires the submitted parent ID to belong to that user. The same restrictions apply when editing an existing child record.
