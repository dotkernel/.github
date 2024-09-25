# Git Attributes

After working hard on that new update and finally getting it to run properly in the late hours of the evening, you expect to push your changes and be done, right?
Imagine if on top of all the work you already did, you also have to contend with issues during merging, unreadable diffs and line endings.
To make your life easier, the git attributes file addresses these topics by defining how it handles files in a repository.
The result is consistency, improved collaboration and optimized workflows to push your update live faster and cleaner.
If you've worked with .gitignore in the past, you should have a good idea how to start working with git attributes.

# What does the git attributes file look like?

A git attributes file is a simple text file named `.gitattributes` that assigns attributes to pathnames.
Each line in the git attributes file is of the form: `pattern attr1 attr2 ...`

These are the elements of an attribute:
- The **pattern** can be 
	- a file name e.g. `myFile.png`
	- a directory name e.g. `docs/`
	- or a wildcard expression that matches multiple paths e.g. `submodule/*`.
- The **attributes** are key-value pairs that tell Git how to handle those paths.

# Git attributes location and precedence

The location of the git attributes file is relevant to its precedence.
This is relevant if you have multiple files of this sort e.g. in a folder in your repository, on its index or in a file specified in `git-config`.
If the same attribute is used in multiple places, the highest precedence will be used.
- The **highest precedence** is for the git attributes in the `$GIT_DIR/info/attributes` directory.
This is most useful when temporarily overwriting attributes without updating the commited `.gitattributes` file.
- The **global attributes file** is applied to all repositories on your local machine, so it ensures e.g. consistent handling of line endings.
This is defined via the command `git config --global core.attributesfile {location}` where `{location}` is the the folder where the `.gitattributes` file is located.
- The **subdirectory-level file** is useful for applying different attributes between e.g. the `src` vs `docs` folder.
- The **repository level** which is the root of your repository and applies to the whole project.
These rules come into play for anyone who clones or works on your repository.

# What are the most useful things to set up in a git attibutes file?

- Text File Normalization - **End-of-line (EOL) handling** enforces a specific line ending on checkout. This attribute normalizes line endings (LF) on checkin and checkout.

`* text=auto`

- Binary File Management - **Binary files** are not human-readable and should not be merged or diffed by Git. This example tells Git that PNG files are binary, so they will not be merged as if they were text and their line endings will be left alone.

`*.png binary`

- Merge Strategies - **Custom merge drivers** are merge strategies applied for particular files or file types. This example uses the `text` merge strategy, which marks conflicts where needed. Alternatives are `binary` and `union`, but their results should be reviewed by the user.

`*.lock merge=text`

- Text Conversion - **Keyword substitution** will replace keywords in files. In this example $Id$ in PHP files will be replaced with information about the commit. The replacement is reverted to the keywork on checkin.
 
`*.php ident`

- Diffing - Setting **diff drivers** for certain file types. Using this attribute affects how the diff text is generated.
    
`*.md diff=markdown`

- Export Filtering - **Include/Exclude files in archive**. This excludes the `reports` folder from the archive.
    
`reports/ export-ignore`

- Path-Specific Settings - **Settings Per Path** withh apply attributes to specific paths. This applies the `text` attribute to all .txt files within the docs/ directory, which also enables EOL conversion if necessary.
    
`docs/*.txt text`

# Related links

https://git-scm.com/docs/gitattributes
