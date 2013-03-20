serializable-models
===================

Models persistency achieved by serialization

### All objects are persists in serialized form ###

Something like this:

<table>
    <tr>
        <th>id</th>
        <th>ref</th>
        <th>className</th>
        <th>serialized</th>
    </tr>
    <tr>
        <td>1</td>
        <td></td>
        <td>Company</td>
        <td>{"name":"XIAG"}</td>
    </tr>
    <tr>
        <td>2</td>
        <td></td>
        <td>CreditCard</td>
        <td>{"properties":{"pan":"9500000000000001","paymentSystem":"VISA","validTo":"2015-12-31T00:00:00+07:00"}}</td>
    </tr>
    <tr>
        <td>3</td>
        <td>1</td>
        <td>Employee</td>
        <td>{"properties":{"title":"Mr.","firstName":"Maxim","lastName":"Gnatenko","phone":"+7923-117-2801","email":"maxim@xiag.ch"},"creditCard":"2","tags":[],"company":"1"}</td>
    </tr>
</table>
