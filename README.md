# php-git
Implementing git from scratch using PHP (not just libgit)

### Getting Started

`php git.php init` // Creates new init config

Init file looks like this:

```
[user]
name = <PUT YOUR NAME HERE>
email = <PUT YOUR EMAIL HERE>
```

Sample:

```
[user]
name = John Doe
email = john@doe.com
```

### Adding a file

`php git.php add <filename>`

### Committing 

For now, you have to look up the `tree`, then run: `php git.php commit <tree hash> <message>`

### Fin
That's it so far.
