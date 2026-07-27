---
icon: lucide/database-search
---

# Event queries

Assuming you have a `meetings` section and that the entry type has an event date field with the handle `eventDate`,
you can query all ongoing and upcoming meetings in your template as follows:

```twig
{% set meetings = craft.entries()
    .section('meetings')
    .eventDate({ lastEnd: '>= now' })
    .orderBy('eventDate ASC')
    .all() %}
```

| Criteria                  | Result                                            |
| ------------------------- | ------------------------------------------------- |
| `{ lastEnd: '>= now' }`   | Ongoing and future (last occurrence hasn't ended) |
| `{ lastEnd: '< now' }`    | Past (all occurrences have ended)                 |
| `{ firstStart: '> now' }` | Only future (no occurrence has started)           |
