---
title: IcsMethod
---

# Enum IcsMethod

Methods for iCalendar (VEVENT) calendar components.

## Cases

- `PUBLISH` - Post notification of an event. Used primarily as
  a method of advertising the existence of an event.
- `REQUEST` - Make a request for an event. This is an explicit
  invitation to one or more "Attendees". Event
  Requests are also used to update or change an
  existing event. Clients that cannot handle
  REQUEST may degrade the event to view it as an
  PUBLISH.
- `REPLY` - Reply to an event request. Clients may set their
  status ("partstat") to ACCEPTED, DECLINED,
  TENTATIVE, or DELEGATED.
- `ADD` - Add one or more instances to an existing event.
- `CANCEL` - Cancel one or more instances of an existing
  event.
- `REFRESH` - A request is sent to an "Organizer" by an
  "Attendee" asking for the latest version of an
  event to be resent to the requester.
- `COUNTER` - Counter a REQUEST with an alternative proposal,
  Sent by an "Attendee" to the "Organizer".
- `DECLINECOUNTER` - Decline a counter proposal. Sent to an
  "Attendee" by the "Organizer".
