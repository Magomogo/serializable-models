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
        <th>meta</th>
    </tr>
    <tr>
        <td>1</td>
        <td></td>
        <td>Company</td>
        <td>O:7:"Company":2:{s:11:"Companyid";N;s:13:"Companyname" ...</td>
        <td>XIAG</td>
    </tr>
    <tr>
        <td>2</td>
        <td></td>
        <td>CreditCard</td>
        <td>O:10:"CreditCard":4:{s:14:"CreditCardid";N;s:15:"CreditC ...</td>
        <td>VISA</td>
    </tr>
    <tr>
        <td>3</td>
        <td>1</td>
        <td>Employee</td>
        <td>C:8:"Employee":265:{a:4:{s:10:"properties";O:17:"Person\P ...</td>
        <td>Mr.,Maxim,Gnatenko,+7923-117-2801,maxim@xiag.ch,VISA</td>
    </tr>
</table>
